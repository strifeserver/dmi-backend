<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Session;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $maxAttempts = 0; // Default is 5
    protected $decayMinutes = 0; // Default is 1
    protected $GenSet = array();
    /**
     * Where to redirect users after login.
     *
     * @var string
     */



    protected $redirectTo = '/';

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        //$GeneralSettings =$this->getGeneralSettings();

        $_Login_throttle = $this->GenSet['Login_throttle'];
        if(isset($_Login_throttle)){
          if($_Login_throttle == 'ON'){
            $_MaxAttempts = $this->GenSet['MaxAttempts'];
            $_DecayMinutes = $this->GenSet['DecayMinutes'];
            $this->maxAttempts = $_MaxAttempts;
            $this->decayMinutes = $_DecayMinutes;
          }
        }

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function username(){
        return 'username';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->GenSet =$this->getGeneralSettings();
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user){
        $pwd_aging = $this->GenSet['Password Aging'];
        $otp = $this->GenSet['OTP'];
        $FA = $this->GenSet['2FA'];

        $request->session()->forget('password_expired_id');
        $request->session()->forget('password_reset_id');
        Session::forget('2fa:user:id');
        Session::forget('otp:counter');
        Session::forget('otp:user:id');
        Session::forget('otp:resendCtr');
        Session::forget('2fa:counter');
        Session::forget('password_reset_id');

        $password_updated_at = $user->password_updated_at;
        $account_lock_end = $user->account_lock_end;
        $password_expiry_days = $pwd_aging;
        $password_expiry_at = Carbon::parse($password_updated_at)->addDays($password_expiry_days);

        if($account_lock_end != ''){
          if(Carbon::now() < $account_lock_end){
            auth()->logout();
            $endTime = Carbon::parse($account_lock_end)->format('h:i:s');

            $msg = 'Your account is lock until :'.$endTime;
            $request->session()->flash('error', $msg);
            return redirect('login');
          }else{
            //$_user=User::find($user->id);
            $user->account_lock_end = '';
            $user->save();
          }
        }

        ///singit otp

        if($password_expiry_at->lessThan(Carbon::now())){
            $request->session()->put('password_expired_id',$user->id);
            auth()->logout();
            $request->session()->flash('error', 'Your Password is expired, You need to change your password.');
            return redirect('/passwordExpiration');
        }

        if($user->temporary_password != ''){
          Session::put('password_reset_id',$user->id);
          auth()->logout();
          return redirect('/passwordReset');
        }

        if(isset($FA)){
          if($FA == 'ON'){
            Session::put('2fa:user:id', $user->id);
            Session::put('2fa:counter',0);
            Auth::logout();
            return redirect('/password2FA');;
          }
        }

        if(isset($otp)){
          if($otp == 'ON'){
            Session::put('otp:user:id', $user->id);
            Session::put('otp:counter',0);
            Session::put('otp:resendCtr',0);
            ///generate otp

            $content = 'OTP';
            $response = $this->sendSms($user->mobile_number, $content);
            $response = explode('|', $response);

            $user->otp_expired_on = $response[2];
            $user->save();


            Session::put('otp:sid', $response[1]);
            Session::put('otp:expired:on', $response[2]);
            ///
            auth()->logout();
            return redirect('/passwordOTP');
          }
        }

        // Auth::logoutOtherDevices($request->input('password'));
        return redirect()->intended($this->redirectPath());
    }

    // Login
    public function showLoginForm($fromForcedLogout = false){

      $image = $this->GenSet['login_banner'];
      $forgot_password = $this->GenSet['forgot_password'];
      $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true,
          'fromForcedLogout' => $fromForcedLogout
      ];

      Session::forget('2fa:user:id');
      Session::forget('otp:counter');
      Session::forget('otp:user:id');
      Session::forget('otp:resendCtr');
      Session::forget('2fa:counter');
      Session::forget('password_reset_id');

      return view('/auth/login', [
          'image' => $image,
          'pageConfigs' => $pageConfigs,
          'fromForcedLogout' => $fromForcedLogout,
          'frgt_password'=>$forgot_password
      ]);
    }


    public function fromForcedLogout() {
      return $this->showLoginForm(true);
    }

    protected function credentials(Request $request){
       return ['username' => $request->{$this->username()}, 'password' => $request->password, 'account_status' => 1];
    }

    protected function validateLogin(Request $request){
        $request->validate([
            $this->username() => ['string','required'],
            'password' => 'required|string',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request){
        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        $errors = [$this->username() => trans('auth.failed')];
        if(isset($user->temporary_password)){
          if($user->temporary_password != ''){
            $errors = ['temp_password' => trans('auth.temp_pass')];
          }
        }
        if ($user && \Hash::check($request->password, $user->password) && $user->active != 1) {
            $errors = [$this->username() => 'Your account is not active.'];
        }
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }



    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  idle|invalidated $isForced
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request,$forced = null){
        //, $forced = null
        $this->guard()->logout();
        $request->session()->invalidate();

        $loginRedirect = redirect('/login');

        if($forced == 'idle') {
          $loginRedirect->with('forced', true)
            ->with('forced-reason', 'You were logged out for inactivity'); // double-login

        } else if($forced == 'expired') {
          $loginRedirect->with('forced', true)
            ->with('forced-reason', 'You were logged out.');
        }

        return $this->loggedOut($request) ?: $loginRedirect;
    }
}
