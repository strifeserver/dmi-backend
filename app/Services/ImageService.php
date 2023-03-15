<?php

namespace App\Services;
use App\CoreSetting;
use DB;
class ImageService
{

    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }

    public function imagePngToFile($image)
    { // change .png to .file
        // $profileImage = $image->getClientOriginalName(); // returns original name
        $extension = $image->getclientoriginalextension(); // returns the file extension
        if ($extension == 'PNG' || $extension == 'png') {
            $extension = 'file';
        }

        return $extension;
    }

    public function image_uploader($image_file, $backend_location, $frontend_location, $name_random = false, $frontend_copy = false)
    {
        if (!empty($image_file)) {
            $init_loc = '';
            $front_path = CoreSetting::where('setting_name', '=', 'parallel_frontend_image_paths')->first();
            if($front_path){
                $init_loc = $front_path->setting_value;
            }

            $imageName = $image_file->getClientOriginalName();

            $imageExt = $image_file->getclientoriginalextension();

            if ($name_random) {
                $ImageNewName = $this->randomId($imageName) . '.' . $imageExt;
            } else {
                $ImageNewName = $imageName;
            }
    
            $image_file->move(public_path($backend_location), $ImageNewName);

            ##PROCESS COPY FILE TO FRONTEND
            DB::table('core_api_logs')->insert([
                'remarks' => 'image_uploader|frontend_to|' . $frontend_copy,
                'data' => json_encode($init_loc . $frontend_location . $ImageNewName),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if ($frontend_copy) {
                try {
                    $copyprod = file_put_contents($init_loc . $frontend_location . $ImageNewName, file_get_contents(public_path($backend_location . '/' . $ImageNewName)));

                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            ##PROCESS COPY FILE TO FRONTEND
            return $ImageNewName;
        } else {
            return 'error';
        }
    }

}
