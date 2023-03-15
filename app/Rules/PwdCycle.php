<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use Illuminate\Support\Facades\Hash;
class PwdCycle implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $pwdcycle = 0;

    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
    
    $DBpwd_cycle = \DB::table('core_settings')->select('setting_value')->where('setting_name','pwd_cycle')->first();    
    $pwd_cycle = isset($DBpwd_cycle->setting_value) ? intval($DBpwd_cycle->setting_value) : 3;
    $this->pwdcycle = $pwd_cycle; 
    $s = User::join('core_passwords', 'core_passwords.user_id', '=', 'core_users.id')->where('core_users.id',5)
      ->orderBy('core_passwords.id', 'desc')->select('core_passwords.old_password')->paginate($pwd_cycle);  
    $arr = array();
        foreach ($s as $key => $v) {
           $arr[] = $v->old_password;
        }   
        //$hash = '0p;/)P:?';    
        $hash = $value;    
        $chk = 0;
        foreach ($arr as $a) {
            $chk += (Hash::check($hash, $a)) ? 1 : 0;
        } 
        if($chk > 0){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Unable to use your last '.$this->pwdcycle.' password.';
    }
}
