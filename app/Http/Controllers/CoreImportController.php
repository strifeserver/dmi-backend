<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Services\ImportService;


class CoreImportController extends Controller
{
    public function validator(Request $request)
    {
      $input = [
                 'import_file'=> $request->file('import_file')
                ];
      $rules = [
                 // 'import_file' => 'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt'
                 'import_file' => 'required|mimetypes:text/csv,text/plain,application/csv'
                 ];
      $messages = [
                    'import_file' => 'Invalid File type'
      ];
      $customAttributes = [
        'import_file' => 'Import File',
        ];                

        
      $validator = Validator::make($input, $rules, $messages,$customAttributes);
    //   return $validator->validate();
    $errs = $validator->errors()->toArray();    
    return $errs;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = $this->validator($request);
        $returns = $this->importService->create($request);
    
        return $returns;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
