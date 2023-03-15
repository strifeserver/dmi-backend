<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Validator;
class CoreImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function validator(Request $request)
    {
      $input = [
                 'file_category'=> $this->sanitizer($request->input('file_category')),
                 'file'=> $request->file('file'),
                ];
      $rules = [
                 'file_category'=> 'nullable|string|max:80',
                 'file' => 'required|max:20',
                 'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                 ];
      $messages = [];
      $customAttributes = [
        'file_category' => 'File Category',
        'file' => 'Image'
        ];
      $validator = Validator::make($input, $rules, $messages,$customAttributes);
      return $validator->validate();
    }








    public function index()
    {
        $folder_lists = [''];
        $uploaded_files = [];
        foreach ($folder_lists as $folder_list) {
             $files = File::allFiles(public_path('images/'.$folder_list)); 
             foreach ($files as $key => $file) {
                $fileName = pathinfo($file)['filename'];
                $ext = pathinfo($file)['extension'];
                $uploaded_files[] = ['origin'=>$folder_list,'filename'=>$fileName,'file_extension'=>$ext]; 
             }
        }
        $rows = $uploaded_files;
        $arr_set = array('editable'=>false,'sortable'=>true,'filter'=>true,'width'=>195, 'flex'=>1);
        $columnDefs = array();
        $columnDefs[] = array_merge(array('headerName'=>'Filename','field'=>'filename'), $arr_set);
        $columnDefs[] = array_merge(array('headerName'=>'File Extension','field'=>'file_extension'), $arr_set);
        $columnDefs[] = array_merge(array('headerName'=>'File Category','field'=>'origin'), $arr_set);
        $return_data = json_encode(array('rows'=>$rows,'column'=>$columnDefs));
        $accesslevel = $this->acclvl();
        return view('pages.core_images.index',['title'=>'Files'])->with('add_link', 'images1/create')->with('agrid_data', json_encode(array('rows'=>$rows,'column'=>$columnDefs)))->with('controls',$accesslevel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $folder_lists = [''];
        $mode = 'Upload';
        $accesslevel = json_decode($this->acclvl());
        if($accesslevel->add){
            return view('pages.core_images.create',[
                'mode'=>$mode,
                'file_categories'=>$folder_lists,
                'title'=>'Image'
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
            $newfile = [];

                if($validator['file']){
                    foreach ($validator['file'] as $image) {
                            $imageName = $image->getClientOriginalName();
                            $newfile[] = $imageName;
                            $ImageNewName = $imageName;
                            $image->move(public_path('images/'),$ImageNewName);

                            $path = ('images');
                            $uploader= $this->imageUpload($image,$path);


                    }
                }


            $this->audit('', 'Uploaded', 'File: name: '.json_encode($newfile), '');
            return redirect()->route('images1.index')->with('success','File Uploaded Successfully');
        }else{
            $audit = $this->audit('','','UNAUTHORIZED','');
            return abort(404);
        }
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
