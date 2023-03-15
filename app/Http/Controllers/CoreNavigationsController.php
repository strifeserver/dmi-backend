<?php

namespace App\Http\Controllers;
use App\CoreNavigation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoreNavigationsController extends Controller
{

    public function index()
    {
        // FILTER DATA
            $nav_types = [['status_name'=>'main'],['status_name'=>'single']];


            $filters =  [
                            ['filter_name'=>'Route Type','filter_code'=>'nav_type','filter_type'=>'dropdown_filter','dropdown_data'=>$nav_types],
                            // ['filter_name'=>'Status','filter_code'=>'status','filter_type'=>'dropdown_filter','dropdown_data'=>$statuses],
                        ];
        // FILTER DATA

        // TABLE DATA
        $rows = CoreNavigation::whereIn('nav_type',array('main','single'))->latest()->get();

        // array formats
            $arr_set = array('editable'=>false,'sortable'=>true,'filter'=>true,'width'=>195);
            $arr_set_hidden = array('hide' => true);
            $wrapCell = array(
                'editable' => false,'sortable' => true,'filter' => true,'cellClass' => 'cell-wrap-text','autoHeight' => true
            );
        // array formats

        $column[] =  array_merge(array('headerName'=>'ID', 'field'=>'id'), $arr_set_hidden);
        $column[] =  array_merge(array('headerName'=>'NAVIGATION NAME', 'field'=>'nav_name'), $arr_set);
        $column[] =  array_merge(array('headerName'=>'NAVIGATION TYPE', 'field'=>'nav_type'), $arr_set);
        $column[] =  array_merge(array('headerName'=>'NAVIGATION ORDER', 'field'=>'nav_order'), $arr_set);
        // HIDDEN ROWS, FOR EXPORT DISPLAY
        $column[] =  array_merge(array('headerName'=>'DATE CREATED', 'field'=>'created_at'), $arr_set_hidden);
        $column[] =  array_merge(array('headerName'=>'DATE UPDATED', 'field'=>'updated_at'), $arr_set_hidden);
        // HIDDEN ROWS, FOR EXPORT DISPLAY
        $controls_btn_index = count($column);
        $return_data = json_encode(array('rows'=>$rows,'column'=>$column));
        // TABLE DATA

        $audit = $this->audit('','','','');
        $accesslevel = $this->acclvl();
        return view('pages.navigations.index', [
            'page'=>'navigations',
            'title'=>'Navigations',
            'agrid_data' => $return_data,
            'add_link' => 'navigations/create',
            'controls' => $accesslevel,
            'data_filters' => $filters,
            'controls_btn_index' => $controls_btn_index,
            'is_import'=> false // set to true if you have import function for this table then set checkbox in access level.
        ]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mode = 'Create';
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->add){
            $audit = $this->audit('','','','');
            $hide = 'display:block;';
            $hide_me = 'display:none;';
            $subnav = array();
            return view('pages.navigations.navigations_create',['mode'=>$mode,'title'=>'Navigations',
                'subnav'=>$subnav ,'hidesub'=>$hide,'hide_me'=>$hide_me]);
            //return view('pages.navigations.navigations_create',['mode'=>$mode,'title'=>'Navigations']);
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
            if($request->input('nav_type') == 'single'){
                $navController = $request->input('nav_controller');
                $navigation = new CoreNavigation();
                $navigation->nav_name           = $request->input('nav_name');
                $navigation->nav_mode           = $request->input('nav_mode');
                $navigation->nav_controller     = $request->input('nav_controller');
                $navigation->nav_type           = $request->input('nav_type');

                $rules = [
                    'nav_name'    => 'required|string|max:50|unique:CoreNavigation',
                    'nav_mode' => 'required|string|max:50|unique:CoreNavigation',
                    'nav_controller' => 'required|string|max:50|unique:CoreNavigation',
                    'nav_type' => 'required|string',
                ];

                $validatedData = $request->validate($rules);
                $navigation->save();

                //$this->generate_files_v1($navController);

            }else{
                $navigation = new CoreNavigation();
                $navigation->nav_name           = $request->input('nav_name');
                $navigation->nav_mode           = $request->input('nav_mode');
                $navigation->nav_controller     = $request->input('nav_controller');
                $navigation->nav_type           = 'main';

                $rownum = ($request->input('rownum') != null) ? $request->input('rownum') : array();
                if(count($rownum) > 0){
                    $navigation->save();
                    $last_id = $navigation->id;

                    $sub_name = $request->input('sub_name');
                    $sub_mode = $request->input('sub_mode');
                    $cont_name = $request->input('controller');
                    $order = $request->input('order');
                    $x = 0;

                    while ($x < count($rownum)) {
                        $_sub_name = $sub_name[$x];
                        $_sub_mode = $sub_mode[$x];
                        $_cont_name = $cont_name[$x];
                        $_order = isset($order[$x]) ? $order[$x] : '1';
                        $navigation = new CoreNavigation();
                        $navigation->nav_name           = $_sub_name;
                        $navigation->nav_mode           = $_sub_mode;
                        $navigation->nav_controller     = $_cont_name;
                        $navigation->nav_type           = 'sub';
                        $navigation->nav_suborder       = $_order;
                        $navigation->nav_parent_id      = $last_id;
                        $this->generate_files_v1($navigation->nav_controller);
                        $navigation->save();

                    $x++;
                    }
                }else{
                    return redirect('/navigations/create')->with("error","Sub navigation list is empty");
                }
            }
            $audit = $this->audit('','','',$navigation->id);
            return redirect()->route('navigations.index')->with('info','Navigation Added Successfully');
        }else{
            $audit = $this->audit('','','UNAUTHORIZED','');
            return abort(404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\navigations  $navigations
     * @return \Illuminate\Http\Response
     */
    public function show(CoreNavigation $navigations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\navigations  $navigations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->edit){
            $navigation = CoreNavigation::find($id);
            $audit = $this->audit('','','',$navigation->id);
            $mode = 'Update';
            $sub_nav = CoreNavigation::where('nav_parent_id',$id)->get();
            $hide = (count($sub_nav) > 0 ) ? 'display:none;' : 'display:block;';
            $hide_me = (count($sub_nav) > 0 ) ? 'display:block;' : 'display:none;';

            // return view('pages.navigations.navigations_create',['mode'=>$mode,'navigation'=>$navigation,'title'=>'Navigations']);
            return view('pages.navigations.navigations_create',['mode'=>$mode,'navigation'=>$navigation,'title'=>'Navigations',
                'subnav'=>$sub_nav,'hidesub'=>$hide,'hide_me'=>$hide_me]);
        }else{
            $audit = $this->audit('','','UNAUTHORIZED',$id);
            return abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\navigations  $navigations
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, CoreNavigation $navigations)
    {

        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->edit){

            if($request->input('nav_type') == 'single'){
                $navigation = CoreNavigation::find($request->input('id'));
                $navigation->nav_name           = $request->input('nav_name');
                $navigation->nav_mode           = $request->input('nav_mode');
                $navigation->nav_controller     = $request->input('nav_controller');
                $navigation->nav_type           = $request->input('nav_type');
                $navigation->save();
                $audit = $this->audit('','','',$navigation->id);

                $r_sub= CoreNavigation::where('nav_parent_id',$request->input('id'));
                $r_sub->delete();
                return redirect()->route('navigations.index')->with('info','Navigations Updated Successfully');
            }else{
                $navigation = CoreNavigation::find($request->input('id'));
                $navigation->nav_name           = $request->input('nav_name');
                $navigation->nav_mode           = $request->input('nav_mode');
                $navigation->nav_type           = 'main';

                $navigation->save();

                $arr_sub = array();
                $sub_nav = CoreNavigation::where('nav_parent_id',$request->input('id'))->get();
                foreach ($sub_nav as $key => $value) {
                   $arr_sub[] = $value->nav_name;
                }
                $last_id = $request->input('id');
                $rownum = $request->input('rownum');
                $sub_name = $request->input('sub_name');
                $sub_mode = $request->input('sub_mode');
                $cont_name = $request->input('controller');
                $order = $request->input('order');
                $x = 0;

                $rownum = ($request->input('rownum') != null) ? $request->input('rownum') : array();
                if(count($rownum) > 0){
                    while ($x < count($rownum)) {
                        $_sub_name = $sub_name[$x];
                        $_sub_mode = $sub_mode[$x];
                        $_cont_name = $cont_name[$x];
                        $_order = isset($order[$x]) ? $order[$x] : '1';

                        if(!in_array($_sub_name, $arr_sub)){

                            $navigation = new CoreNavigation();
                            $navigation->nav_name           = $_sub_name;
                            $navigation->nav_mode           = $_sub_mode;
                            $navigation->nav_controller     = $_cont_name;
                            $navigation->nav_type           = 'sub';
                            $navigation->nav_suborder       = $_order;
                            $navigation->nav_parent_id      = $last_id;
                            $this->generate_files_v1($navigation->nav_controller);
                            $navigation->save();

                        }
                    $x++;
                    }

                    $remove_sub=array_diff($arr_sub,$sub_name);
                    foreach ($remove_sub as $key => $r) {
                         $r_sub= CoreNavigation::where('nav_name',$r);
                         $r_sub->delete();
                    }

                }else{
                    $d = $request->input('id');
                    return redirect('/navigations/'.$d.'/edit')->with("error","Sub navigation list is empty");
                }

               return redirect()->route('navigations.index')->with('info','Navigations Updated Successfully');
            }


        }else{
            $audit = $this->audit('','','UNAUTHORIZED',$request->input('id'));
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\navigations  $navigations
     * @return \Illuminate\Http\Response
     */
    public function destroy($navigations)
    {

        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->delete){
            $color = CoreNavigation::find($navigations);
            $color->delete();

            $r_sub= CoreNavigation::where('nav_parent_id',$navigations);
            $r_sub->delete();

            return redirect()->route('navigations.index')->with('info','Navigations Updated Successfully');
           
        }else{
            $audit = $this->audit('','','UNAUTHORIZED',$navigations);
            return abort(404);
        }
    }
}
