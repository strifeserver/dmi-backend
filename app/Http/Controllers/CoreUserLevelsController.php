<?php

namespace App\Http\Controllers;

use App\CoreUserLevel;
use App\CoreNavigation;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoreUserLevelsController extends Controller
{
    protected $user_level;
    public function __construct(CoreUserLevel $user_level){
        $this->user_level = $user_level;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function validator(Request $request)
    {
        return $this->validate($request, [
            'accesslevel'=>'required|max:50|unique:core_user_levels,accesslevel',
        ]);
    }

    public function index()
    {
        $rows = array();
        $access= auth::user()->access_level;
        if($access==1){
          $rows = $this->user_level->all();
        }else{
          $rows = $this->user_level->where('id', '<>', 1)->select()->get();
        }


        $arr_set = array('editable'=>false,'sortable'=>true,'filter'=>true);

        foreach($rows as $i) {

            // convert allowed modules to html string
            $allowedModules = $this->loadModules($i['id']);
            $i['allow_module_html'] = view(
                'pages.user_levels.module_tree',
                [ 'menu' => $allowedModules ])
                ->render();

            $i['allowed_modules_fmt'] = $this->prettyPrint($allowedModules);
        }

        $columnDefs = array();
        //$columnDefs[] = array_merge(array('headerName'=>'ID','field'=>'id'), $arr_set);
        $columnDefs[] = array_merge(array('headerName'=>'Access Level','field'=>'accesslevel'), $arr_set);
        $columnDefs[] = array_merge(array('hide' => true, 'headerName'=>'Access Level Formatted','field'=>'allowed_modules_fmt'), $arr_set);


        $jsonEncoded = json_encode([
            'rows' => $rows,
            'column' => $columnDefs
        ]);

        $audit = $this->audit('','','','');
        $accesslevel = $this->acclvl();

        return view('pages.user_levels.user_levels', [
            'title'=>'Users Level'
        ])->with('agrid_data', $jsonEncoded)->with('add_link','user_levels/create')->with('controls',$accesslevel);
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
            $audit = $this->audit('','','','');
            return view('pages.user_levels.user_levels_create', [
                'mode' => 'Create',
                'title' => 'Users Level',
                'modules' => $this->loadModules()
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
            $res = $this->validator($request);

            $user_level = new CoreUserLevel();
            $this->_processModuleInput($request, $user_level);

            $access_level_code = str_replace(' ', '_', $user_level->accesslevel);
            $user_level->accesslevel_code = $access_level_code;

            $user_level->save();
            $audit = $this->audit('','','',$user_level->id);
            return redirect()->route('user_levels.index')->with('info','Access Level Added Successfully');


        }else{
            $audit = $this->audit('','','UNAUTHORIZED','');
            return abort(404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CoreUserLevel  $CoreUserLevel
     * @return \Illuminate\Http\Response
     */
    public function show(CoreUserLevel $CoreUserLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CoreUserLevel  $CoreUserLevel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->edit){
            $user_level = CoreUserLevel::find($id);
            $mode = 'Update';
            $params = [
                'mode' => $mode,
                'user_level' => $user_level,
                'modules' => $this->loadModules($id)
            ];

            return view('pages.user_levels.user_levels_create', $params);


        }else{
            $audit = $this->audit('','','UNAUTHORIZED',$id);
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoreUserLevel  $CoreUserLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoreUserLevel $CoreUserLevel)
    {
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->edit){
            $user_level = CoreUserLevel::find($request->input('id'));
            $this->_processModuleInput($request, $user_level);
            $user_level->save();
            $audit = $this->audit('','','',$user_level->id);
            return redirect()->route('user_levels.index')
                ->with('info','Access Level Updated Successfully');
        }else{
            $audit = $this->audit('','','UNAUTHORIZED',$request->input('id'));
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoreUserLevel  $CoreUserLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy($CoreUserLevel)
    {
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->delete){
            $color = CoreUserLevel::find($CoreUserLevel);
            $color->delete();
            $audit = $this->audit('', '', '', $CoreUserLevel);

            return redirect()
                ->route('user_levels.index')
                ->with('info', 'Access Level Updated Successfully');
        }else{
            $audit = $this->audit('','','UNAUTHORIZED',$CoreUserLevel);
            return abort(404);
        }
    }

    private function _explodeIf($array) {
        return $array ? explode(',', $array) : [];
    }

    private function _processModuleInput(Request $request, $model) {
        $rootModules = $request->input('root_module', []);
        $subModules = $request->input('sub_module', []);
        $combined = $rootModules + $subModules;
        $allowAdd = [];
        $allowEdit = [];
        $allowDelete = [];
        $allowImport = [];
        $allowExport = [];
        $allowModules = array_keys($rootModules);
        $allowSubModules = array_keys($subModules);

        // return response()->json([
        //     $rootModules,
        //     $subModules,
        //     $combined
        // ]);

        foreach($combined as $id => $e) {
            if(isset($e['add'])) $allowAdd[] = $id;
            if(isset($e['edit'])) $allowEdit[] = $id;
            if(isset($e['delete'])) $allowDelete[] = $id;
            if(isset($e['import'])) $allowImport[] = $id;
            if(isset($e['export'])) $allowExport[] = $id;
        }

        // name
        $model->accesslevel = $request->input('accesslevel');
        // $model->accesslevel_code = $request->input('accesslevel_code');

        // modules
        $model->allow_module = sizeof($allowModules) ? implode(',', $allowModules) : null;
        $model->allow_submodule = sizeof($allowSubModules) ? implode(',', $allowSubModules) : null;
        $model->add = sizeof($allowAdd) ? implode(',', $allowAdd) : null;
        $model->edit = sizeof($allowEdit) ? implode(',', $allowEdit) : null;
        $model->delete = sizeof($allowDelete) ? implode(',', $allowDelete) : null;
        $model->import = sizeof($allowImport) ? implode(',', $allowImport) : null;
        $model->export = sizeof($allowExport) ? implode(',', $allowExport) : null;
    }


    // Prepare modules for edit/create view
    private function loadModules($userLevel = -1) {
        $mainNavs = CoreNavigation::where('nav_type', 'main')->get();
        $singleNavs = CoreNavigation::where('nav_type', 'single')->get();
        $subNavs = CoreNavigation::where('nav_type', 'sub')->get();
        $_edit = CoreUserLevel::find($userLevel) ?? [];

        // [id] => allow, add, edit, delete, import, export

        if($_edit) {
            $allowedRoot = $this->_explodeIf($_edit->allow_module);
            $allowedSubModule = $this->_explodeIf($_edit->allow_submodule);
            $allowedAdd = $this->_explodeIf($_edit->add);
            $allowedEdit = $this->_explodeIf($_edit->edit);
            $allowedDelete = $this->_explodeIf($_edit->delete);
            $allowedImport = $this->_explodeIf($_edit->import);
            $allowedExport = $this->_explodeIf($_edit->export);

            // $combined = $allowedRoot + $allowedSubModule;
            $navsPermissions = [];

            $assignPermission = function($mode, $navs) use (&$navsPermissions) {
                foreach($navs as $i) {
                    if(isset($navsPermissions[$i])) {
                        $navsPermissions[$i][$mode] = true; // add
                    } else {
                        $navsPermissions[$i] = [ $mode => true ]; // create w/ 1 element
                    }
                }
            };

            $assignPermission('allow', $allowedRoot);
            $assignPermission('allow', $allowedSubModule);
            $assignPermission('add', $allowedAdd);
            $assignPermission('edit', $allowedEdit);
            $assignPermission('delete', $allowedDelete);
            $assignPermission('import', $allowedImport);
            $assignPermission('export', $allowedExport);
        }

        /*
        map $_edit to:
        /*
        Node[id] => [
            id,
            name,
            permissions => [],
            children => [ <Node> ]
        ]
        */
        $rootModules = [];

        // get all main navs first
        foreach($mainNavs as $i) {
            $rootModules[$i['id']] = [
                // 'id' => ,
                'name' => $i['nav_name'],
                'path' => $i['nav_mode'],
                'permissions' => $_edit ? ($navsPermissions[$i['id']] ?? []) : [],
                'sub_modules' => []
            ];
        }

        foreach($singleNavs as $i) {
            $rootModules[$i['id']] = [
                // 'id' => ,
                'name' => $i['nav_name'],
                'path' => $i['nav_mode'],
                'permissions' => $_edit ? ($navsPermissions[$i['id']] ?? []) : [],
                'sub_modules' => []
            ];
        }

        // assign subnavs to parent
        foreach($subNavs as $i) {
            // exists?
            $parentID = $i['nav_parent_id'];

            if(isset($rootModules[$parentID])) {
                // sub_modules[id] = []
                $rootModules[$parentID]['sub_modules'][$i['id']] = [
                    'name' => $i['nav_name'],
                    'path' => $i['nav_mode'],
                    'permissions' => $_edit ? ($navsPermissions[$i['id']] ?? []) : []
                ];
            }
            // ignore if parent is not present
        }

        return  $rootModules;
    }

    // for export: readable form of allowed modules
    public function prettyPrint($allowedModules)
    {
        // dashboard: foo,bar,baz; nav1: sub11,sub2
        $result = '';

        foreach($allowedModules as $i) {
            $subModules = implode(',',
                array_column($i['sub_modules'], 'name')
            );

            $result .= "{$i['name']}: ($subModules); ";
        }

        return $result;
    }
}
