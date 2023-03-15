<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class CoreGeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_settings')->insert([
            'setting_name' => 'site_title',
            'setting_value' => 'Core',
            'setting_description' => 'Website Title'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'footer_title',
            'setting_value' => 'STRIFE SERVER',
            'setting_description' => 'Website Footer'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'Password Aging',
            'setting_value' => '30',
            'setting_description' => 'Days to force user to change password.'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'Login_throttle',
            'setting_value' => 'ON',
            'setting_description' => 'Count number of incorrect attempt , values ON/OFF'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'MaxAttempts',
            'setting_value' => '2',
            'setting_description' => 'max number of login attempts'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'DecayMinutes',
            'setting_value' => '1',
            'setting_description' => 'timer before you can log in again values in define in minutes: 1 = 1 min'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'OTP',
            'setting_value' => 'OFF',
            'setting_description' => 'set ON/OFF for verification via otp'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => '2FA',
            'setting_value' => 'OFF',
            'setting_description' => 'set ON/OFF for verification via otp'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'Password_Complex',
            'setting_value' => 'OFF',
            'setting_description' => 'set ON/OFF for password complexity'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'OTP_MaxAttempts',
            'setting_value' => '3',
            'setting_description' => 'set max attempts of otp'
        ]);
        DB::table('core_settings')->insert([
            'setting_name' => 'OTP_TempLockDuration',
            'setting_value' => '3',
            'setting_description' => 'set number of minutes temporary lock'
        ]);
        DB::table('core_settings')->insert([
            'setting_name' => 'OTP_MaxResend',
            'setting_value' => '3',
            'setting_description' => 'set number of max count of resend'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'OTP_Expiration',
            'setting_value' => '5',
            'setting_description' => 'set number of minutes where otp is valid'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => '2FA_MaxAttempts',
            'setting_value' => '3',
            'setting_description' => 'set max attempts of google auth',
            'category' => '2fa_google'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => '2FA_TempLockDuration',
            'setting_value' => '3',
            'setting_description' => 'set number of minutes temporary lock',
            'category' => '2fa_google'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => '2FA_qr_name',
            'setting_value' => 'Default',
            'setting_description' => 'QR Name',
            'category' => '2fa_google'
        ]);
        DB::table('core_settings')->insert([
            'setting_name' => '2FA_qr_email',
            'setting_value' => 'Default@email.com',
            'setting_description' => 'QR Email',
            'category' => '2fa_google'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'idle_timeout',
            'setting_value' => '3000', // seconds
            'setting_description' => 'How long in seconds before logging out for inactivity: Use zero if OFF'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'login_banner',
            'setting_value' => 'login.png', // seconds
            'setting_description' => 'Login Banner'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'page_logo',
            'setting_value' => 'core_logo.png', // seconds
            'setting_description' => 'Page Logo'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'pwd_cycle',
            'setting_value' => '3', // seconds
            'setting_description' => 'Number of last password that cannot be use again'  
        ]);

        DB::table('core_settings')->insert([
           'setting_name' => 'forgot_password',
            'setting_value' => 'ON', // seconds
            'setting_description' => 'Value must be ON - OFF'
        ]);

        DB::table('core_settings')->insert([
           'setting_name' => 'sms_api_originator',
            'setting_value' => '',
            'setting_description' => 'Sms Api Originator'
        ]);

        DB::table('core_settings')->insert([
           'setting_name' => 'sms_api_pw',
            'setting_value' => '',
            'setting_description' => 'Sms Api Password'
        ]);

        DB::table('core_settings')->insert([
            'setting_name' => 'sms_api_uname',
             'setting_value' => '', // 
             'setting_description' => 'Sms Api Url'
         ]);

        DB::table('core_settings')->insert([
           'setting_name' => 'sms_api_url',
            'setting_value' => 'api url', // 
            'setting_description' => 'Sms Api Url'
        ]);

    }
}
