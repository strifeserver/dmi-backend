<?php

namespace App\Http\Controllers;

use App\CoreEmailTemplate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination\AcceptsPagination;
use App\Http\Controllers\Pagination\PageData;
use App\Http\Controllers\Pagination\Paginatable;
use App\Support\AgGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use App\Services\PageService;
use App\Services\EmailTemplateService;
use App\Http\Requests\EmailPostRequest;
class EmailTemplatesController extends Controller implements Paginatable
{
    
    

    use AcceptsPagination;

    public function __construct(CoreEmailTemplate $db, EmailTemplateService $service, PageService $pageService)
    {
        $this->db_table = $db;
        $this->service = $service;
        $this->pageService = $pageService;
    }


    public function getColumns(): array
    {
        $table_cols = $this->table_columns();
        $formatted_cols = [];
        $formatted_cols[] = AgGrid::hidden('id');
        foreach ($table_cols as $key => $value) {
            $table_name = $value['table_name'];
            $table_headername = ($value['headerName']) ? $value['headerName'] : null;
            $is_display = $value['is_display'];

            $column_width = $value['column_width'];


            $arr_counter = count($formatted_cols);    
            $to_insert = '';

            if($is_display == true){
                if($column_width == 'W_SMALL'){
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_SMALL);
                }
                if($column_width == 'W_MEDIUM'){
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_MEDIUM);
                }
                if($column_width == 'W_WIDE'){
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_WIDE);
                }
                if($column_width == 'W_ULTRAWIDE'){
                    $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_ULTRAWIDE);
                }
            }else{
                $to_insert = AgGrid::hidden($table_name);
            }
            $formatted_cols[] = $to_insert; 
        }

        return $formatted_cols;

    }

    // DATA FILTERING AND PAGINATION

    public function getPage(int $start, int $end, ?array $sortModel, ?object $filterModel): PageData
    {
        $ctrl_var = $this->controller_variables();
        
        if($ctrl_var['accesslevel']->index){
            $rows = $this->db_table->select()
        ->when($filterModel, function($query, $filterModel){
            foreach ($filterModel as $key => $value) {
                if($key == 'created_at'){
                    $created_at = explode(" to ", $filterModel->created_at->filter);
                    $format_date = $this->filter_date_format_v2($created_at[0],$created_at[1]);
                    $from = $format_date['from'];
                    $to = $format_date['to'];  
                    $query->whereBetween('created_at', [$from, $to]);
                }else{
                    $query->where($key,'LIKE','%'.$value->filter.'%');
                }
            }
            return $query;
        })
        ->paginate($end)
        ->toArray();
        $total = $rows['total'];
        $data = $rows['data'];
        $data = $this->change_value($data);  
 
        return new PageData(
            $total,
            $data
            );
        }
    }


    public function validator(Request $request)
    {
        $id = $this->sanitizer($request->input('id'));

        $input = [
            'email_header'=> $this->sanitizer($request->input('email_header')),
            'email_body'=> $request->input('email_body'),
            'status'=> $this->sanitizer($request->input('status')),
        ];

        $rules = [
            'email_header'=> 'required|string',
            'email_body'=> 'required|string',
            'status'=> 'required|numeric',
        ];

        $messages = [];

        $customAttributes = [
            'email_header'=> 'Subject',
            'email_body'=> 'Body',
            'status'=> 'Status',
        ];                

        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        return $validator->validate();
    }



    public function controller_variables(){
        $accesslevel = json_decode($this->acclvl());
        $controller_res = [];
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE
        $controller_res['site_title'] = 'Email Template'; 
        $controller_res['folder_name'] = 'email_template';
        $controller_res['accesslevel'] = $accesslevel;
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE
        return $controller_res;
    }

    public function table_columns(){
        // DEFINE YOUR TABLE COLUMN DISPLAY HERE
        $table_col_display = [];
        $table_col_display[] = ['table_name' => 'email_header','headerName'=> 'EMAIL HEADER','is_display'=>true,'is_widen'=>false, 'column_width'=>'W_WIDE'];
        $table_col_display[] = ['table_name' => 'status','headerName'=> 'STATUS','is_display'=>true,'is_widen'=>false, 'column_width'=>'W_WIDE'];
        $table_col_display[] = ['table_name' => 'created_at','headerName'=> 'DATE CREATED','is_display'=>true,'is_widen'=>false, 'column_width'=>'W_WIDE'];
        $table_col_display[] = ['table_name' => 'updated_at','headerName'=> 'DATE UPDATED','is_display'=>true,'is_widen'=>false, 'column_width'=>'W_WIDE'];

        return $table_col_display;
    }

    public function index()
    {
        
        // // FILTER DATA
            $statuses = [['status_name'=>'Active'],['status_name'=>'Inactive']];
          
            $filters =  [
                            ['filter_name'=>'Page Status','filter_code'=>'status','filter_type'=>'dropdown_filter','dropdown_data'=>$statuses],
                            ['filter_name'=>'Date Filter','filter_code'=>'created_at','filter_type'=>'date_filter','dropdown_data'=>null] #sample_date filter
                        ];
        // // FILTER DATA

        
        $table_version = 'v2';               
        $table_version_file = 'mixed';               
        #v1 - load all data, frontend filtering
        #v2 - backend filtering data
        #table_version_file
        #default - using v1 and v2 js file
        #mixed - same file with v1 and v2 switchable tables


        if($table_version == 'v1'){
            $return_data = $this->table_v1()['return_data'];
            $controls_btn_index = $this->table_v1()['controls_btn_index'];
        }

        $page_variables = $this->page_variables([
            'mode'=>'index',
            'agrid_data'=>@$return_data,
            'data_filters'=>$filters,
            'controller_variables'=>$this->controller_variables()
        ]);
        
        # ADD PARAMS HERE TO FURTHER ADD RETURNS
        $page_variables['static'] = [
            'title' =>$page_variables['title'],
            'controls' => json_decode($page_variables['controls']),
            'columns' =>    $this->getColumns(),
            'pagination_link' => url('paginate/'.$page_variables['folder_name']),
            'agrid_data'=>($table_version =='v1') ? $return_data : null,
            'data_filters'=>$filters,
            'page'=>$page_variables['page'],
            'controls_btn_index'=>@$controls_btn_index,
            'routes' => [
                $page_variables['folder_name'].'.edit' => route($page_variables['folder_name'].'.edit', ':id'),
                $page_variables['folder_name'].'.destroy' => route($page_variables['folder_name'].'.destroy', ':id'),
            ],
            'table_version' =>$table_version, #v1 v2 options
            'table_version_file' =>$table_version_file, #v1 v2 options
        ];

        return view($page_variables['index_page'], $page_variables);
    }




    public function filter(request $request){
        # MAKE SURE YOU HAVE A NEW ROUTE CREATED FOR THIS FILTER similar to general_settings IN core_filter_links table
        # function automatically reads it as filter_general_settings 


        // Define Fields in this validator
        $validator = $this->filter_validator($request);
        // Define Fields in this validator
        $remarks = [];
        if(!empty($validator->original)){
            foreach ($validator->original as $key_a => $value_a) {
                foreach ($value_a as $key_b => $value_b){
                    $remarks[] = $value_b;
                }
            }
            return $remarks;
        }else{
            $format_date = $this->filter_date_format($validator['from'],$validator['to']);
            $from = $format_date['from'];
            $to = $format_date['to'];
            // customize your filters here
            $filter = $this->db_table->whereBetween('created_at', [$from, $to])->get();
            // customize your filters here
            $rowcount = $filter->count();
            $return_data = json_encode(array('rows'=>$filter,'rowcount'=>$rowcount));
            return $return_data;
        }
    }


    public function change_value($rows){
        $search_array = $rows;
          foreach ($search_array as $key => $value) {
                if(Arr::exists($value, 'status')){
                    if($value['status'] === 1){
                        $value['status'] = 'Active';
                    }
                    if($value['status'] === 0){
                        $value['status'] = 'Inactive';
                    }
                }
            }
        return $search_array;
    }



    public function create()
    {
        $page_variables = $this->page_variables(['controller_variables'=>$this->controller_variables(),'mode'=>'Create']);
        return view($page_variables['create_page'], $page_variables);

    }

    public function store(Request $request)
    {
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->add){
            $ctrl_var = $this->controller_variables();
            $page_variables = $this->page_variables(['controller_variables'=>$this->controller_variables(),'mode'=>'Delete']);
            $validator = $this->validator($request);

            $data = $this->db_table->create($validator)->id;
            if($data){
                $auditing = ['data_id'=>$data,'data'=>$validator];
                $core_audit_trail = $this->audit_trail('','CREATE',$auditing,$data);
            }
 
            $this->audit('','','',$data);
            return redirect()->route($page_variables['store_page'])
                ->with('success',$page_variables['title'].' Added Successfully');
        }else{
            $audit = $this->audit('','','UNAUTHORIZED','');
            return abort(404);
        }
    }

    public function edit($id)
    {
      
        $ctrl_var = $this->controller_variables();
        $page_variables = $this->page_variables(['controller_variables'=>$this->controller_variables(),'mode'=>'Update']);
        $edit = $this->db_table->findOrFail($id);
        $page_variables['edit'] = $edit; 

        return view($page_variables['edit_page'], $page_variables);
    }

    public function update(EmailPostRequest $request)
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $validated = $request->validated();
        $validated = (array) $request->all();
  
        $execution = $this->service->update($validated);
        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Updated ' . $execution['message']
            );
    }



    public function destroy($db_table)
    {
        $page_variables = $this->page_variables(['controller_variables'=>$this->controller_variables(),'mode'=>'index']);
        $db_table = $this->db_table->findOrFail($db_table);
        $audit = $this->audit('','','',$db_table->id);
        
        $auditing = ['data_id'=>$db_table->id,'data'=>$db_table];
        
        $saving = $db_table->delete();
        if($saving){
            $core_audit_trail = $this->audit_trail('','DELETE',$auditing,$db_table->id);
            $return_msg = ['type'=>'success','remarks'=>'Successfully Deleted'];
        }else{
            $return_msg = ['type'=>'error_comment','remarks'=>'Failed to Delete'];
        }
        return redirect()->route($page_variables['destroy_page'])->with($return_msg['type'],$return_msg['remarks']);
    }









}
