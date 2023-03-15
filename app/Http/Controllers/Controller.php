<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use App\CoreNavigation;
use Artisan;
use App\User;
use App\CoreSetting;
use App\Telco_prefix;
use Carbon\Carbon;
use Purifier;
use Str;
use GuzzleHttp\Client;
use App\Jobs\SendEmailJob;
use App\CoreUserLevel;
use Illuminate\Support\Facades\Http;
trait QueuesEmailSending
{
    public function pushEmail($sendto, $subject, $message, $attachment = '', $remarks = '')
    {
        $send_mail = ['sendto' => $sendto, 'message' => $message, 'subject' => $subject, 'attachment' => $attachment, 'remarks' => $remarks];
        $dispatcher = dispatch(new SendEmailJob($send_mail));
        if($dispatcher){
            \DB::table('core_email_outboxes')->insert([
                'email' => $sendto,
                'subject' => $subject,
                'content' => $message,
                'remarks' => 'QUEUING',
                'created_by' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }

        return 'QUEUED'; // ON QUEUE
    }
}

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, QueuesEmailSending;


    public function logged_account_details(){
        $returns = [];
        $logged_in_access_level = Auth::user()->access_level;
        $CoreUserLevel = CoreUserLevel::where('id','=',$logged_in_access_level)->first();
        $returns = ['access_level_id'=>$logged_in_access_level,'access_level_code'=>$CoreUserLevel->accesslevel_code,'access_level_name'=>$CoreUserLevel->accesslevel];
        $returns['stores'] = Auth::user()->stores;
        return $returns;
    }

    public function unique_multidimensional_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
    
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }



    public function audit($module='',$action_taken='',$remarks,$dataid = '',$category=''){
        $user = Auth::user();
        $username = $user->username;
        $currentPath= Route::getFacadeRoot()->current()->uri();
        $currentPath = explode('/', $currentPath);
        $module =strtoupper($currentPath[0]);
        $mode = strtoupper((array_key_exists(2, $currentPath)) ? $currentPath[2] : '');
        if($remarks==''){
            $action_taken = ($mode == 'EDIT' || $mode == 'DELETE') ? $mode.' ID: '.$dataid :(($action_taken =='') ? 'VIEWING '.$module : $action_taken );
        }
        DB::table('core_audit_trail_logs')->insert([
            'module' => $module,
            'username' => $username,
            'action_taken' => $action_taken,
            'remarks' => $remarks,
            'category' => $category,
            'ip' => $this->get_client_ip(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }


    public function audit_trail($module='',$action_taken='',$remarks='', $dataid = '',$category=''){
        $user = Auth::user();
        $username = $user->username;
        $currentPath= Route::getFacadeRoot()->current()->uri();
        $currentPath = explode('/', $currentPath);
        $module =strtoupper($currentPath[0]);
        $mode = strtoupper((array_key_exists(2, $currentPath)) ? $currentPath[2] : '');

        $data = [
            'module' => $module,
            'username' => $username,
            'action_taken' => $action_taken,
            'remarks' => json_encode($remarks),
            'category' => $category,
            'ip' => $this->get_client_ip(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        DB::table('core_audit_trail_logs')->insert($data);
    }

    public function acclvl(){
       $index = (Gate::allows('index')) ? true : false;
       $add = (Gate::allows('add')) ? true : false;
       $edit = (Gate::allows('edit')) ? true : false;
       $delete = (Gate::allows('delete')) ? true : false;
       $import = (Gate::allows('import')) ? true : false;
       $export = (Gate::allows('export')) ? true : false;
       $acceslvl = json_encode(array('index'=> $index,'add'=> $add,'edit'=>$edit,'delete'=>$delete,'import'=>$import,'export'=>$export));
       return $acceslvl;
    }

    public function generate_files($controller,$model){
        $artisan_controller = Artisan::queue('make:controller', ['--resource' => $controller,'name'=>$controller]);
        $artisan_model = Artisan::queue('make:model', ['--migration' => $model,'name'=>$model]);

        $name_dir = str_replace('Controller', '', $controller);
        $str_path = public_path();
        $path = str_replace('public', 'resources\views\pages\\'.$name_dir, $str_path);

        if(!file_exists($path)){
            mkdir($path);
        }

        if(file_exists($path)){ ////generate views
            $destination = $path.'\index.blade.php';
            $origin = str_replace('public', 'resources\views\core\base_crud_layout\index.blade.php', public_path()) ;
            copy($origin, $destination);

            $destination = $path.'\create.blade.php';
            $origin = str_replace('public', 'resources\views\core\base_crud_layout\create.blade.php', public_path()) ;
            copy($origin, $destination);

            $destination = $path.'\edit.blade.php';
            $origin = str_replace('public', 'resources\views\core\base_crud_layout\edit.blade.php', public_path()) ;
            copy($origin, $destination);
        }

    }

    public function generate_files_v1($controller){
        $artisan_controller = Artisan::queue('make:model', ['-m' => $controller, '-c'=>$controller, '-r'=>$controller, 'name'=>$controller]);
        $artisan_model = Artisan::queue('make:model', ['--migration' => $model,'name'=>$model]);

        $name_dir = str_replace('Controller', '', $controller);
        $str_path = public_path();
        $path = str_replace('public', 'resources\views\pages\\'.$name_dir, $str_path);

        if(!file_exists($path)){
            mkdir($path);
        }

        if(file_exists($path)){ ////generate views
            $destination = $path.'\index.blade.php';
            $origin = str_replace('public', 'resources\views\core\base_crud_layout\index.blade.php', public_path()) ;
            copy($origin, $destination);

            $destination = $path.'\create.blade.php';
            $origin = str_replace('public', 'resources\views\core\base_crud_layout\create.blade.php', public_path()) ;
            copy($origin, $destination);

            $destination = $path.'\edit.blade.php';
            $origin = str_replace('public', 'resources\views\core\base_crud_layout\edit.blade.php', public_path()) ;
            copy($origin, $destination);
        }

    }

    public function page_variables($data){

        $accesslevel = $this->acclvl();
        $accesslevel_check = json_decode($this->acclvl(),true);
        // Required Data ------------------------
        $title = $data['controller_variables']['site_title'];
        $mode = $data['mode'];
        $page = $data['controller_variables']['folder_name']; #for create/update page redirects in js
        $folder_name = $data['controller_variables']['folder_name'];
        $static = @$data['controller_variables']['static'];

        // Required Data ------------------------

        // Not Required Data ------------------------
        $edit = @$data['edit'];
        $agrid_data = @$data['agrid_data'];
        $add_link = $folder_name.'/create'; #for create page link
        // $controls = @$data['controls'];
        $data_filters = @$data['data_filters'];
        if($data_filters){
            $filter_count = count($data_filters);
        }else{
            $filter_count = 0;
        }
        $controls_btn_index = @$data['controls_btn_index'];
        // Not Required Data ------------------------
        $crud_pages = [
            'index_page'=>'pages.'.$folder_name.'.index',
            'create_page'=>'pages.'.$folder_name.'.create',
            'store_page'=>''.$folder_name.'.index',
            'edit_page'=>'pages.'.$folder_name.'.create',
            'update_page'=>''.$folder_name.'.index',
            'destroy_page'=>''.$folder_name.'.index',
        ];

        $mode_check = strtolower($mode);
        if(!$accesslevel_check['add'] && $mode_check == 'create'){
            return abort(404);
        }
        if(!$accesslevel_check['edit']  && $mode_check == 'edit'){
            return abort(404);
        }
        if(!$accesslevel_check['delete']  && $mode_check == 'delete'){
            return abort(404);
        }

        if($static){

        }

        $page_variables = [
            'title'=>$title,
            'folder_name'=>$folder_name,
            'mode'=>$mode,
            'edit'=>$edit,
            'page'=>$page,
            'agrid_data'=>$agrid_data,
            'add_link'=>$add_link,
            'controls'=>$accesslevel,
            'data_filters'=>$data_filters,
            'data_filters_a'=>json_encode($data_filters),
            'filter_count'=>$filter_count,
            'controls_btn_index'=>$controls_btn_index,
            'is_import'=>false,
            'static'=>@$static,


        ];
        $page_res = array_merge($page_variables, $crud_pages);
        return $page_res;
    }

    public function generate_otp($user_id){
        $CoreSetting = CoreSetting::where('setting_name','OTP_Expiration')->first();
        $exp_minutes = isset($CoreSetting->setting_value) ? intval($CoreSetting->setting_value) : 3;
        $expired = new Carbon();
        $expired->addMinutes($exp_minutes);
        $randomid = mt_rand(100000,999999);
        $user = User::find($user_id);
        $user->otp = $randomid;
        $user->otp_expired_on = $expired->format('Y-m-d H:i:s');
        $user->save();

        return $randomid;
    }




    public function sendSms($mobilenum, $fullmesg)
    {
        $gen_settings = $this->getGeneralSettings();
        $api_url = $gen_settings['sms_api_url'];
        $username = $gen_settings['sms_api_username'];
        $password = $gen_settings['sms_api_pw'];
        $originator = $gen_settings['sms_api_originator'];

        $raw = [
            'mode' => 'gen',
            'originator' => $originator,
            'mobilenum' => $mobilenum,
        ];

        ksort($raw);
        $hash = '';

        foreach ($raw as $key => $value) {
             $hash .= $value;
        }
        $hash = md5($hash.$password);

         if ($api_url && $username) {

            $response = Http::withHeaders([
                'username' => $username,
                'hash' => $hash,
            ])->post($api_url,[
                'mode' => 'gen',
                'originator' => $originator,
                'mobilenum' => $mobilenum,
            ]);

            $resp =  $response->body();
            
            return $resp;
        } else {
            return 'No SMS Config found';
        }

    }

    public function otp_validation($sid, $code)
    {
        $gen_settings = $this->getGeneralSettings();
        $api_url = $gen_settings['sms_api_url'];
        $username = $gen_settings['sms_api_username'];
        $password = $gen_settings['sms_api_pw'];
        $originator = $gen_settings['sms_api_originator'];

        $raw = [
            'mode' => 'validate',
            'sid' => $sid,
            'code' => $code,
        ];

        ksort($raw);
        $hash = '';

        foreach ($raw as $key => $value) {
             $hash .= $value;
        }
        $hash = md5($hash.$password);

        $response = Http::withHeaders([
            'username' => $username,
            'hash' => $hash,
        ])->post($api_url,[
            'mode' => 'validate',
            'sid' => $sid,
            'code' => $code,
        ]);

        $resp =  $response->body();

        return $resp;
    }



    public function filter_date_format($requestFrom,$requestTo){
        $datefrom1 = explode('-', $requestFrom);
        $dateto1 = explode('-', $requestTo);
        $from1 = $datefrom1[2] . '-' . $datefrom1[0] . '-' . $datefrom1[1] . ' 00:00:00';
        $to = $dateto1[2] . '-' . $dateto1[0] . '-' . $dateto1[1] . ' 23:59:59';

        $return = ['from'=>$from1,'to'=>$to];
        return $return;
    }

    public function filter_date_format_v2($requestFrom,$requestTo){
        $datefrom1 = explode('-', $requestFrom);
        $dateto1 = explode('-', $requestTo);
        $from1 = $datefrom1[0] . '-' . $datefrom1[1] . '-' . $datefrom1[2] . ' 00:00:00';
        $to = $dateto1[0] . '-' . $dateto1[1] . '-' . $dateto1[2] . ' 23:59:59';

        $return = ['from'=>$from1,'to'=>$to];
        return $return;
    }

    public function getGeneralSettings(){
    $general_settings = DB::table('core_settings')->select('setting_name','setting_value')->get();
      $arr = array();
      foreach ($general_settings as $key => $val) {
        $arr[$val->setting_name] = $val->setting_value;
      }

      return $arr;
    }
    public function imagePngToFile($image){ // change .png to .file
        // $profileImage = $image->getClientOriginalName(); // returns original name
        $extension = $image->getclientoriginalextension(); // returns the file extension
        if ($extension == 'PNG' || $extension == 'png' ) {
            $extension = 'file';
        }

        return $extension;
    }

    public function imageSize($image){
        $imageInfo = getimagesize($image);
        return $imageInfo;
    }

    public function imageUpload($image, $path){
        if ($image->isValid()) {
            $storageFolder = $path;

            $newExtension = $this->imagePngToFile($image); // Controller.php
            $newProfileImage = strtoupper(Str::random(20)).'.'.$newExtension;
            $move = $image->storeAs($storageFolder, $newProfileImage);

            if ($move) {
                return $newProfileImage;
            }
        }
    }

    public function changeImage($img, $path, $conversion){
        if (!empty($img)) {
            $image = @explode('.', $img);

            if ($conversion == 'file-to-png') {
                $imageName = $image[0];
                $imageExt = ($image[1] == 'file') ? 'png' : $image[1];
                $oldImage = $path.$img;
                $newImage = $path.$image[0].'.png'; // if imageExt is png;

                if ($imageExt == 'png') {
                    @rename($oldImage, $newImage);
                }

                $fullPath = $path.$imageName.'.'.$imageExt;
                if (file_exists($fullPath)) {
                    return $imageName.'.'.$imageExt;  
                }else{
                    return 'Image Not Found';
                }
            }
        }
    }


    public function sanitizer($input){
      // $return = Purifier::clean(strip_tags(htmlspecialchars($input)));
        $return = \Purifier::clean($input,['HTML.Allowed' => '']);
      return $return;
    }



    public function clean_mobile($mobile){
        $newmobilenum = preg_replace("/[^0-9]/",'',$mobile);
        $newmobilenum = ((strlen($newmobilenum)>=10) && ($newmobilenum != "") && (substr($newmobilenum,-10,1)=='9')) ? "63" . substr($newmobilenum,-10) : "";
        return $newmobilenum;
      }
  
  
    public function getTelco($pref){
        $res = Telco_prefix::select('telco_code')->where('Telco_prefix',$pref)->pluck('telco_code')->take(1)->toArray();
        return (count($res) > 0) ? $res[0] : '';
      }


    public function api_audit($api_data){



        $data = [
            'remarks' => $api_data['remarks'],
            'data' => $api_data['data'],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
        DB::table('core_api_logs')->insert($data);
    }
    public function api_receive($data){

        $data_auditing = json_encode($data->all());
        $api_auditing = ['remarks'=>'api_receive','data'=>$data_auditing];
        $api_auditing = $this->api_audit($api_auditing);

        return $data;
    }

    public function api_return($data){
        $data = json_encode($data);
        $api_auditing = ['remarks'=>'api_return','data'=>$data];
        $api_auditing = $this->api_audit($api_auditing);
        return response($data);
    }

    public function code_name_rephrase($data,$tbl_name='',$fld_name=''){
        $data = str_replace(" ","_",$data);
        $data = strtolower($data);
        if($tbl_name !=null && $fld_name !=null){
            $validator = \Validator::make(['id'=>$data],['id'=>'unique:'.$tbl_name.','.$fld_name.'']);
            if($validator->fails()){
                $data = str_replace(" ","_",$data);
                $data = strtolower($data);
                $randomizer = Str::random(3);
                $data = $data.$randomizer;
            }
        }else{
            $data = str_replace(" ","_",$data);
            $data = strtolower($data);
        }
        return $data;
    }

}
