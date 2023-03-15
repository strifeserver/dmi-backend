<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Response;
use Cache;
use Google2FA;
use Session;
use App\Rules\PwdCycle;
use App\CorePassword;
use App\Rules\ComplexPassword;

class PasswordController extends Controller
{
    protected $GenSet = array();

    public function __construct(){
        $this->GenSet =$this->getGeneralSettings();
    }
    ///PASSWORD EXPIRED/////
    public function showPasswordExpirationForm(Request $request){
        $image = $this->GenSet['login_banner']; 
            
        $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
        ];

        $password_expired_id = $request->session()->get('password_expired_id');
        if(!isset($password_expired_id)){
            return redirect('/login');
        }
        return view('auth.passwords.passwordExpiration', ['pageConfigs' => $pageConfigs,'image' => $image]);  
    }

    public function postPasswordExpiration(Request $request){
        $password_expired_id = $request->session()->get('password_expired_id');
        if(!isset($password_expired_id)){
            return redirect('/login');
        }

        $user = User::find($password_expired_id);
        if (!(Hash::check($request->get('current_password'), $user->password))) {
            return redirect('/passwordExpiration')->with('error','Your current password does not matches with the password you provided. Please try again.');
        }

        if(strcmp($request->get('current_password'), $request->get('new-password')) == 0){
            return redirect('/passwordExpiration')->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        
        $pc = $this->GenSet['Password_Complex'];
        $paasoword_complex = isset($pc) ? $pc : 'OFF';

        $pass_comp = ($paasoword_complex == 'ON') ? array('required','string',new ComplexPassword,'confirmed',new PwdCycle) 
                                                  : array('required','string','confirmed',new PwdCycle) ;
        $validatedData = $request->validate(['new-password' => $pass_comp]);

        $this->reset_pass($password_expired_id,$request);
        return redirect('/login')->with("status","Password changed successfully!");
    }
    ///PASSWORD EXPIRED/////

    ///PASSWORD RESET/////
    public function showPasswordReset(Request $request){
        $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
        ];

        $password_reset_id = $request->session()->get('password_reset_id');
        if(!isset($password_reset_id)){
            return redirect('/login');
        }
        return view('auth.passwords.passwordReset', ['pageConfigs' => $pageConfigs]);  
    }


    public function reset_pass($user_id,$request){
        $user = User::find($user_id);
        $old_pass = $user->password;
         //Change Password
        $user->password = $request->get('new-password');
        $user->password_updated_at = Carbon::now();
        $user->temporary_password = '';
        $user->temporary_password_created = '';
        $user->save();
        //Change Password

        //Password History
        $array = array('user_id'  => $user_id,
                       'old_password' => $old_pass
                     );
        CorePassword::create($array);
        //Password History
    }

    public function postPasswordReset(Request $request){
    	//$password_reset_id = $request->session()->get('password_reset_id');
        $password_reset_id = Session::get('password_reset_id');
        if(!isset($password_reset_id)){
            return redirect('/login');
        }

        $pc = $this->GenSet['Password_Complex'];
        $paasoword_complex = isset($pc) ? $pc : 'OFF';

        $pass_comp = ($paasoword_complex == 'ON') ? array('required','string',new ComplexPassword,'confirmed',new PwdCycle) 
                                                  : array('required','string','confirmed',new PwdCycle) ;

        $validatedData = $request->validate([
            'new-password' => $pass_comp,
        ]);
        $this->reset_pass($password_reset_id,$request);
        Auth::logout();
        return redirect('/login')->with("status","Password changed successfully!");
    }
    ///PASSWORD RESET/////


    /////OTP///////////
    public function showPasswordOtpForm(Request $request){

        $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
        ];

        $password_otp = Session::get('otp:user:id');
        $user =User::find($password_otp);
        $expiration_otp = ($user->otp_expired_on != '') ? $user->otp_expired_on : '2019-01-01 00:00:00';
        $expired_on = Carbon::parse($expiration_otp);
        $f_expired_on = $expired_on->toFormattedDateString().' '.$expired_on->toTimeString();

        
        $dbOTP_MaxResend = $this->GenSet['OTP_MaxResend'];
        $OTP_MaxResend = isset($dbOTP_MaxResend) ? intval($dbOTP_MaxResend) : 3;
        $resend_ctr = Session::get('otp:resendCtr');
        $available_resend = ($OTP_MaxResend >= $resend_ctr) ? ($OTP_MaxResend - $resend_ctr) : 0; 
        if(!isset($password_otp)){
            return redirect('/login');
        }
        return view('auth.passwords.passwordOTP', ['pageConfigs' => $pageConfigs,'expired_on' =>$f_expired_on,'resend'=>$available_resend]);  
    }

    public function postPasswordOTP(Request $request){
        //if tama    
        //Auth::login($user);

        // $otp = $this->GenSet['OTP_MaxAttempts'];
        // $max_otp = isset($otp) ? intval($otp) : 3;
        // $userId = Session::get('otp:user:id');
        // $try_ctr = Session::get('otp:counter');
        // $user=User::find($userId);
        // if($request->otp != $user->otp){
        //     //$old_ctr = $try_ctr;
        //     $try_ctr = $try_ctr + 1;
        //     Session::put('otp:counter',$try_ctr);
            
        //     if($try_ctr > $max_otp){ ////exceed max attempts
        //         //$otp_tmpLock = \DB::table('core_settings')->select('setting_value')->where('setting_name','OTP_TempLockDuration')->first();
        //         $otp_tmpLock = $this->GenSet['OTP_TempLockDuration'];
        //         $minutes = isset($otp_tmpLock) ? intval($otp_tmpLock) : 3;
        //         $endTime = new Carbon();
        //         $endTime->addMinutes($minutes);
                 
        //         $until = $endTime->format('h:i:s A');
        //         $user->account_lock_end =  $endTime->format('Y-m-d H:i:s ');
        //         $user->save();
        //         $request->session()->flash('error', 'Your account is lock until : '.$until);
        //         return redirect('/login'); 
        //     }

        //     $msg_append = $try_ctr.' of '.$max_otp .'.';
        //     $request->session()->flash('error', 'Invalid digit otp code '.$msg_append);
        //     return redirect('/passwordOTP'); 
        // }else{
        //     $current = Carbon::now();
        //     if($user->otp_expired_on < $current){
        //         return redirect('/passwordOTP'); 
        //     }
        // }

        $otp = $this->GenSet['OTP_MaxAttempts'];
        $max_otp = isset($otp) ? intval($otp) : 3;
        $userId = Session::get('otp:user:id');
        $try_ctr = Session::get('otp:counter');
        $sid = Session::get('otp:sid');
        $expired_on = Session::get('otp:expired:on');
        $user=User::find($userId);

        $response = $this->otp_validation($sid, $request->otp);
        $response = explode('|', $response);

        if($response[1] != 1){
            $try_ctr = $try_ctr + 1;
            Session::put('otp:counter',$try_ctr);
            if($try_ctr > $max_otp){ ////exceed max attempts
                $otp_tmpLock = $this->GenSet['OTP_TempLockDuration'];
                $minutes = isset($otp_tmpLock) ? intval($otp_tmpLock) : 3;
                $endTime = new Carbon();
                $endTime->addMinutes($minutes);
                             
                $until = $endTime->format('h:i:s A');
                $user->account_lock_end =  $endTime->format('Y-m-d H:i:s ');
                $user->save();
                $request->session()->flash('error', 'Your account is lock until : '.$until);
                return redirect('/login'); 
            }
            $msg_append = $try_ctr.' of '.$max_otp .'.';
            $request->session()->flash('error', 'Invalid digit otp code '.$msg_append);
            return redirect('/passwordOTP'); 
        }else{
            $current = Carbon::now();
            if($expired_on < $current){
                return redirect('/passwordOTP'); 
            }
        }
        
        Auth::loginUsingId($userId);
        return redirect('/');

    }

    public function ResendOTP(){
        $userId = Session::get('otp:user:id');
        $user = User::find($userId);
        if(isset($userId)){

        
        $dbOTP_MaxResend = $this->GenSet['OTP_MaxResend'];
        $OTP_MaxResend = isset($dbOTP_MaxResend) ? intval($dbOTP_MaxResend) : 3;
        $resend_ctr = Session::get('otp:resendCtr');
        $available_resend = ($OTP_MaxResend >= $resend_ctr) ? ($OTP_MaxResend - $resend_ctr) : 0;     

        if($available_resend == 0){
            return redirect('/login');
        }
        $new_resend = $resend_ctr + 1;
        Session::put('otp:resendCtr',$new_resend);

        $content = 'OTP';
        $response = $this->sendSms($user->mobile_number, $content);
        $response = explode('|', $response);

        Session::put('otp:sid', $response[1]);
        Session::put('otp:expired:on', $response[2]);

        return redirect('/passwordOTP');
        }
        return redirect('/login');
    }

    /////OTP///////////
    
    /////GOOGLE AUTH/////
    public function showPassword2FAForm(Request $request){
        $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
        ];

        //$password_2fa = $request->session()->get('2fa:user:id');
        $password_2fa = Session::get('2fa:user:id');
        if(!isset($password_2fa)){
            return redirect('/login');
        }
        return view('auth.passwords.password2FA', ['pageConfigs' => $pageConfigs]);  
    }

    public function postValidateToken(Request $request)
    {

        //$_2fa = \DB::table('core_settings')->select('setting_value')->where('setting_name','2FA_MaxAttempts')->first();

       

        $_2fa = $this->GenSet['2FA_MaxAttempts'];
        $max_2fa = isset($_2fa) ? intval($_2fa) : 3;

        $userId = Session::get('2fa:user:id');
        $key    = $userId.':'.$request->totp;
        Cache::add($key, true, 4);

        $user=User::find($userId);
        $secret=$user->google2fa_secret;

        if($secret == ''){
            $request->session()->flash('error', 'Register Your Google auth first to proceed.');
            return redirect('/password2FA');  
        }
        
        
        $window = 4; // 8 keys (respectively 4 minutes) past and future
        $valid = Google2FA::verifyKey($secret, $request->totp, $window);
        $try_ctr = Session::get('2fa:counter');
        if(!$valid){
            $try_ctr = $try_ctr + 1;
            Session::put('2fa:counter',$try_ctr);

            if($try_ctr > $max_2fa){ ////exceed max attempts
                //$_2fa_tmpLock = \DB::table('core_settings')->select('setting_value')->where('setting_name','2FA_TempLockDuration')->first();
                $_2fa_tmpLock = $this->GenSet['2FA_TempLockDuration'];
                $minutes = isset($_2fa_tmpLock) ? intval($_2fa_tmpLock) : 3;
                $endTime = new Carbon();
                $endTime->addMinutes($minutes);
                 
                $until = $endTime->format('h:i:s A');
                $user->account_lock_end =  $endTime->format('Y-m-d H:i:s ');
                $user->save();
                $request->session()->flash('error', 'Your account is lock until : '.$until);
                return redirect('/login'); 
            }


            $msg_append = $try_ctr.' of '.$max_2fa.'.';
            $request->session()->flash('error', 'Invalid Google authentication code '.$msg_append);
            return redirect('/password2FA');
        }
        Auth::loginUsingId($userId);
        return redirect('/');
    }
    /////GOOGLE AUTH/////


}
