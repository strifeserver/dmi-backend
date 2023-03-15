<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
class AuthService {


    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }
    public function crud_guards($method = null){
        $index = (Gate::allows('index')) ? true : false;
        $add = (Gate::allows('add')) ? true : false;
        $edit = (Gate::allows('edit')) ? true : false;
        $delete = (Gate::allows('delete')) ? true : false;
        $import = (Gate::allows('import')) ? true : false;
        $export = (Gate::allows('export')) ? true : false;
        $acceslvl = ['index'=> $index,'add'=> $add,'edit'=>$edit,'delete'=>$delete,'import'=>$import,'export'=>$export];
        if($method){
            if($method == 'PUT' || $method == 'PATCH' ){
                $acceslvl['authorization'] = $edit;
            }else if($method == 'DELETE' ){
                $acceslvl['authorization'] = $delete;
            }else if($method == 'POST' ){
                $acceslvl['authorization'] = $add;
            }
        }
        return $acceslvl;
    }



}