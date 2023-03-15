<?php

namespace App\Http\Controllers;
use App\CoreAuditTrailLog;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Pagination\AcceptsPagination;
use App\Http\Controllers\Pagination\PageData;
use App\Http\Controllers\Pagination\Paginatable;
use App\Support\AgGrid;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;

class CoreAuditTrailLogsController extends Controller implements Paginatable
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use AcceptsPagination;

    protected $audit_trail;
    public function __construct(CoreAuditTrailLog $audit_trail){
        $this->audit_trail = $audit_trail;
    }
    public function getColumns(): array
    {
        return [
            AgGrid::hidden('id'),
            AgGrid::column('module'),
            AgGrid::column('category'),
            AgGrid::column('username'),
            AgGrid::column('action_taken', null, AgGrid::W_ULTRAWIDE),
            AgGrid::column('created_at', 'Date Created'),
            AgGrid::column('updated_at', 'Date Updated')
        ];
    }

    public function getPage(int $start, int $end, ?array $sortModel, ?object $filterModel): PageData
    {
        $ctrl_var = $this->controller_variables();
        
        if($ctrl_var['accesslevel']->index){
            $rows = CoreAuditTrailLog::select()
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
            ->orderBy('created_at', 'DESC')
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


    public function controller_variables(){
        $accesslevel = json_decode($this->acclvl());
        $controller_res = [];
        $controller_res['site_title'] = 'Audit Trail';
        $controller_res['folder_name'] = 'audit_trail_logs';
        $controller_res['accesslevel'] = $accesslevel;
        
        return $controller_res;
    }


    public function filter_validator(Request $request)
    {
        $input = [
            'from'=> $this->sanitizer($request->input('from')),
            'to'=> $this->sanitizer($request->input('to')),
        ];

        $rules = [
            'from'=> 'required|string',
            'to'=> 'required|string',
        ];

        $messages = [];

        $customAttributes = [
            'from'=> 'Filter From',
            'to'=> 'Filter To',
        ];   
        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        if ($validator->fails()){
            return response($validator->messages()->toArray(), 400);
        }else{
            return $input;
        }
    }




    public function index()
    {
        
        // // FILTER DATA
            $statuses = [['status_name'=>'Active'],['status_name'=>'Inactive']];
            $modules = CoreAuditTrailLog::select('module as status_name')->groupBy('module')->get()->toArray();
          
            $filters =  [
                            ['filter_name'=>'Modules','filter_code'=>'module','filter_type'=>'dropdown_filter','dropdown_data'=>$modules], 
                            ['filter_name'=>'Date Filter','filter_code'=>'created_at','filter_type'=>'date_filter','dropdown_data'=>null] #sample_date filter
                        ];
        // // FILTER DATA
        $table_version = 'v2';               
        #v1 - load all data, frontend filtering
        #v2 - backend filtering data



        $page_variables = $this->page_variables([
            'mode'=>'index',
            'agrid_data'=>@$return_data,
            'data_filters'=>$filters,
            'controller_variables'=>$this->controller_variables()
        ]);
        
        # ADD PARAMS HERE TO FURTHER ADD RETURNS
        $page_variables['static'] = [
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
        ];
       
        return view($page_variables['index_page'], $page_variables);
    }

    public function change_value($rows){
        $search_array = $rows;
          foreach ($search_array as $key => $value) {
                if(Arr::exists($value, 'username')){
                   $search_array[$key]['username'] = strtoupper($search_array[$key]['username']);
                }
            }
        return $search_array;
    }

    public function filter(request $request){
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
            $filter = $this->audit_trail->whereBetween('created_at', [$from, $to])->get();
            // customize your filters here
            $rowcount = $filter->count();
            $return_data = json_encode(array('rows'=>$filter,'rowcount'=>$rowcount));
            return $return_data;
        }


    }

}
