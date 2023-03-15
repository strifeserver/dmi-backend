<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\forgot_password;
use DB;
use App\User;
use Crypt;
// use App\Mail\forgot_password;
use Helpers\Helper;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function __construct(){
        $this->GenSet =$this->getGeneralSettings();
        $this->middleware('guest')->except('logout');
    }

    public function showLinkRequestForm(){

      $forgot_pass = DB::table('core_settings')
      ->where('setting_name', 'forgot_password')
      ->first();


      if($forgot_pass->setting_value == 'ON'){
        $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
        ];

        return view('/auth/passwords/email', [
          'pageConfigs' => $pageConfigs,
          'image' => $this->GenSet['login_banner']
        ])->with('message', json_encode(['msg'=>'']));
      }else{
        return abort(404);
      }
    }

    public function email (Request $request) {
      $forgot_pass = DB::table('core_settings')
      ->where('setting_name', 'forgot_password')
      ->first();


      if($forgot_pass->setting_value == 'ON')
       {
        $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
        ];

        $condi = '';
        $d = User::all();
        foreach ($d as $key => $value) {
          if($value->email == $request->input('email')) {
            $condi = "true";
            $message = 'Email Sent, Please Check your email to proceed';

            $temp_password = $this->generateRandomString();

            $user = User::where('id', $value->id)->first();
            $user->password = $temp_password;
            $user->temporary_password = $value->password;
            $user->temporary_password_created = date('Y-m-d H:i:s');
            $user->save();

            Mail::to(request('email'))->send(new forgot_password($temp_password));
            $val = 1;
          }
        }

        $images = $this->GenSet['login_banner'];

        // password/email

        if(!$condi) {
          // return view('/auth/login', ['pageConfigs' => $pageConfigs, 'image'=>$images])
          //   ->with('message', json_encode(['msg'=>'Email doest not exist','val'=>0]));

          return redirect()->route('login')
            ->with('message', json_encode(['msg'=>'Email does not exist','val'=>0]))
            ->with('pageConfigs', $pageConfigs)
            ->with('image', $images);
          
        }else{
          return redirect()->route('login')
            ->with('message', json_encode(['msg'=>$message,'val'=>1]))
            ->with('pageConfigs', $pageConfigs)
            ->with('image', $images);

          // return view('/auth/login',['pageConfigs' => $pageConfigs, 'image'=>$images])
          //   ->with('message', json_encode(['msg'=>$message,'val'=>1]));
        }
       }else{
        return abort(404);
      }
    }

    public function generateRandomString($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
    }
}
