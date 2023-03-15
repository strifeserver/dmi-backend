<?php

namespace App\Http\Controllers;

use App\CoreController;
use App\CoreSystemStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use DB;
use Auth;
use Validator;
use Artisan;
class CoreControllersController extends Controller
{
    protected $CoreController;
    public function __construct(CoreController $CoreController){
        $this->CoreController = $CoreController;
    }

    public function controller_variables(){
        $controller_res = [];
        $controller_res['folder_name'] = 'controllers';
        
        return $controller_res;
    }

    public function validator(Request $request)
    {
        $input = [
            'url'=> $this->sanitizer($request->input('url')),
            'controller_name'=> $this->sanitizer($request->input('controller_name')),
            'function_name'=> $this->sanitizer($request->input('function_name')),
            'route_type'=> $this->sanitizer($request->input('route_type')),
            'status'=> $this->sanitizer($request->input('status')),
            'model_create'=> $this->sanitizer($request->input('model_create')),
            'model_name'=> $this->sanitizer($request->input('model_name')),
            'blade_create'=> $this->sanitizer($request->input('blade_create')),
            'blade_name'=> $this->sanitizer($request->input('blade_name')),
        ];

        $rules = [
            'url'=>'required|max:50|unique:CoreControllers,url,'.$this->sanitizer($request->input('id')).'',
            'controller_name'=>'required|max:50|unique:CoreControllers,controller_name,'.$this->sanitizer($request->input('id')).'',
            'function_name' => 'required|string',
            'route_type'=> 'required|string',
            'status'=> 'required|string',
            'model_create'=> 'nullable|string',
            'model_name'=> 'nullable|max:50|unique:CoreControllers,model_name,'.$this->sanitizer($request->input('id')).'',
            'blade_create'=> 'nullable|string',
            'blade_name'=> 'nullable|max:50|unique:CoreControllers,blade_name,'.$this->sanitizer($request->input('id')).'',
            
        ];

        $messages = [];

        $customAttributes = [
            'url' => 'URL',
            'controller_name'=> 'Controller Name',
            'function_name'=> 'Function Name',
            'route_type'=> 'Route Type',
            'status'=> 'Status',    
            'model_create'=> 'Model Create',
            'model_name'=> 'Model Name',
            'blade_create'=> 'Blade Create',
            'blade_name'=> 'Blade Name',
        ];

        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        return $validator->validate();
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // FILTER DATA
            $statuses = [['status_name'=>'Active'],['status_name'=>'Inactive']];


            $filters =  [
                            ['filter_name'=>'Page Status','filter_code'=>'status','filter_type'=>'dropdown_filter','dropdown_data'=>$statuses],
                            ['filter_name'=>'Date Filter','filter_code'=>'created_at','filter_type'=>'date_filter','dropdown_data'=>null]
                        ];
        // FILTER DATA

        // TABLE DATA
            $rows = CoreController::latest()->get();
            $rows = $this->change_value($rows);
            // array formats
                $arr_set = array('editable'=>false,'sortable'=>true,'filter'=>true,'width'=>195);
                $arr_set_hidden = array('hide' => true);
                $wrapCell = array(
                    'editable' => false,'sortable' => true,'filter' => true,'cellClass' => 'cell-wrap-text','autoHeight' => true
                );
            // array formats
            $column[] =  array_merge(array('headerName'=>'ID', 'field'=>'id'), $arr_set_hidden);
            $column[] =  array_merge(array('headerName'=>'URL', 'field'=>'url'), $arr_set);
            $column[] =  array_merge(array('headerName'=>'CONTROLLER NAME', 'field'=>'controller_name'), $arr_set);
            $column[] =  array_merge(array('headerName'=>'FUNCTION NAME', 'field'=>'function_name'), $arr_set);
            $column[] =  array_merge(array('headerName'=>'ROUTE TYPE', 'field'=>'route_type'), $arr_set);
            $column[] =  array_merge(array('headerName'=>'STATUS', 'field'=>'status'), $arr_set);
            // HIDDEN ROWS, FOR EXPORT DISPLAY
            $column[] =  array_merge(array('headerName'=>'DATE CREATED', 'field'=>'created_at'), $arr_set_hidden);
            $column[] =  array_merge(array('headerName'=>'DATE UPDATED', 'field'=>'updated_at'), $arr_set_hidden);
            // HIDDEN ROWS, FOR EXPORT DISPLAY
                // $column[] =  array_merge(array('headerName'=>'DATE UPDATED', 'field'=>'updated_at'), $arr_set_hidden);
                // $column[] =  array_merge(array('headerName'=>'DATE UPDATED', 'field'=>'updated_at'), $arr_set_hidden);
            // HIDDEN ROWS, FOR EXPORT DISPLAY
            $controls_btn_index = count($column);
            $return_data = json_encode(array('rows'=>$rows,'column'=>$column));
        // TABLE DATA
        $ctrl_var = $this->controller_variables();
        $page_variables = $this->page_variables(['controller_variables'=>$this->controller_variables(),'mode'=>'index','agrid_data'=>$return_data,'data_filters'=>$filters,'controls_btn_index'=>$controls_btn_index]);
        return view($page_variables['index_page'], $page_variables);
    }



    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->add){
            $core_navigations = DB::table('core_navigations')->where('nav_type','=','main')->get();
            // $core_navigations = DB::table('core_navigations')->where('nav_name','=','Settings')->first();

            $audit = $this->audit('','','','');
            return view('pages.controllers.create', [
              'core_navigations'=>$core_navigations,
              'title'=>'Controllers',
              'mode'=>'Create',
            ]);
          
        }else{
            $audit = $this->audit('','','UNAUTHORIZED','');
            return abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->add){
            $validator = $this->validator($request);


                $controller_name = $validator['controller_name'].'Controller';
                $model_name = 'core_'.$validator['model_name'];
                $blade_name = $validator['blade_name'];

            if($validator['route_type'] == 'resource'){
                $artisan_controller = Artisan::queue('make:controller', ['--resource' => $controller_name,'name'=>$controller_name]);
            }
            if($validator['model_create'] == true){
                $model_name = Str::plural($model_name);
                // $artisan_model = Artisan::queue('make:model', ['--migration' => $model_name,'name'=>$model_name]);
                $artisan_model = Artisan::queue('make:model', ['name'=>$model_name]);
            }

            if($validator['blade_create'] == true){

                $name_dir = $blade_name;
                $str_path = public_path();
                $path = str_replace('public', 'resources\views\pages\\'.$name_dir, $str_path);

                if(!file_exists($path)){
                    mkdir($path);
                }

                if(file_exists($path)){ 
                    $destination = $path.'\index.blade.php';
                    $origin = str_replace('public', 'resources\views\core\base_crud_layout\index.blade.php', public_path()) ;
                    copy($origin, $destination);

                    $destination = $path.'\create.blade.php';
                    $origin = str_replace('public', 'resources\views\core\base_crud_layout\create.blade.php', public_path()) ;
                    copy($origin, $destination);
                }
            }



            $create = new CoreController();
            $create->url = $validator['url']; 
            $create->controller_name = $validator['controller_name']; 
            $create->function_name = $validator['function_name']; 
            $create->route_type = $validator['route_type']; 
            $create->status = $validator['status']; 
            $create->model_create = $validator['model_create']; 
            $create->model_name = @$model_name; 
            $create->blade_create = $validator['blade_create']; 
            $create->blade_name = $validator['blade_name']; 
            $create->save();


            $audit = $this->audit('','','',$create->id);
            return redirect()->route('controllers.index')->with('info','Controller Added Successfully');
              
        }else{
            $audit = $this->audit('','','UNAUTHORIZED','');
            return abort(404);
        }






        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoreController  $CoreController
     * @return \Illuminate\Http\Response
     */
    public function show(CoreController $CoreController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoreController  $CoreController
     * @return \Illuminate\Http\Response
     */
    public function edit(CoreController $CoreController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoreController  $CoreController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoreController $CoreController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoreController  $CoreController
     * @return \Illuminate\Http\Response
     */
    public function destroy($CoreController)
    {   
        $returns = [];
        $controller = $this->CoreController->findOrFail($CoreController);
        if($controller){
            $controller_name = $controller->controller_name.'Controller';
            $model_name = $controller->model_name;
            $blade_name = $controller->blade_name;
            $str_path = public_path();
        }
        $dir = __DIR__ . "/";
        $filelist = scandir($dir);
            foreach ($filelist as $key => $value) {
                if($controller_name.'.php' == $value){
                    $old_file_name = $dir.$value;
                    $new_file_name = $dir.'deleted_'.$value;
                    $rename_file = rename($old_file_name, $new_file_name);
                    if($rename_file){
                        $returns[] = 'Controller Deleted';
                    }
                    $str_path = public_path();
                    $path = str_replace('public', 'resources\views\pages\\'.$blade_name, $str_path);
                    $new_folder_name = str_replace('public', 'resources\views\pages\\'.'deleted_'.$blade_name, $str_path);
                    $rename_folder = rename($path, $new_folder_name);
                    if($rename_folder){
                        $returns[] = 'Folder Deleted';
                    }
                        
                    $str_path = public_path();
                    $model_name_s = Str::plural($model_name).'.php';
                    $model_path = str_replace('public', 'app\\'.$model_name_s, $str_path);
                    $new_model_name = str_replace('public', 'app\\deleted_'.$model_name_s, $str_path);
                    $rename_model = rename($model_path, $new_model_name);
                    if($rename_folder){
                            $returns[] = 'Model Deleted';
                    }
                    
            }
        }


        $page_variables = $this->page_variables(['controller_variables'=>$this->controller_variables(),'mode'=>'index']);
        $CoreController = CoreController::findOrFail($CoreController);
        $audit = $this->audit('','','',$CoreController->id);
        $saving = $CoreController->delete();
        // if($saving){
            $return_msg = ['type'=>'success','remarks'=>'Successfully Deleted'];
        // }else{
        //     $return_msg = ['type'=>'error_comment','remarks'=>'Failed to Delete'];
        // }
        return redirect()->route($page_variables['destroy_page'])->with($return_msg['type'],$return_msg['remarks']);
        
    }

    public function change_value($rows){
    $search_array = $rows;
      foreach ($search_array as $key => $value) {
            if(Arr::exists($value, 'status')){
                 $status = CoreSystemStatus::where('id', '=', $value['status'])
                    ->select('status_name', 'id')
                    ->first();
                $value['status'] = $status->status_name;
            }
        }
    return $search_array;
    }









}
