<?php

namespace App\Services;
use App\CoreSetting;
use DB;
class FileService
{

    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }



    public function file_uploader($file, $backend_location, $frontend_location, $name_random = false, $frontend_copy = false)
    {

        if (!empty($file)) {
            $init_loc = '';
            $front_path = CoreSetting::where('setting_name', '=', 'parallel_frontend_file_paths')->first();
            if($front_path){
                $init_loc = $front_path->setting_value;
            }

            $fileName = $file->getClientOriginalName();

            $fileExt = $file->getclientoriginalextension();

            if ($name_random) {
                $fileNewName = $this->randomId($fileName) . '.' . $fileExt;
            } else {
                $fileNewName = $fileName;
            }
            
    
            $file->move(public_path($backend_location), $fileNewName);

            ##PROCESS COPY FILE TO FRONTEND
            DB::table('core_api_logs')->insert([
                'remarks' => 'file_uploader|frontend_to|' . $frontend_copy,
                'data' => json_encode($init_loc . $frontend_location . $fileNewName),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if ($frontend_copy) {
                try {
                    $copyprod = file_put_contents($init_loc . $frontend_location . $fileNewName, file_get_contents(public_path($backend_location . '/' . $fileNewName)));

                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            ##PROCESS COPY FILE TO FRONTEND
            return $fileNewName;
        } else {
            return 'error';
        }
    }

}
