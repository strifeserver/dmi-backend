<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\CoreEmailTemplate;

class CoreUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_users')->insert([
            'first_name' => Crypt::encrypt('developer'),
            'last_name' => Crypt::encrypt('demo'),
            'access_level' => '1',
            'username' => 'developer@demo.com',
            'email' => Crypt::encrypt('developer@demo.com'),
            'password' => Hash::make('developer'),
            'password_updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        
        ]);

        DB::table('core_users')->insert([
            'first_name' => Crypt::encrypt('Web'),
            'last_name' => Crypt::encrypt('Administrator'),
            'access_level' => '2',
            'username' => 'admin@demo.com',
            'email' => Crypt::encrypt('website_administrator@email.com'),
            'password' => Hash::make('admin'),
            'password_updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ]);

        DB::table('core_users')->insert([
            'hash' => Crypt::encrypt('User'),
            'password' => Hash::make('customer'),
            'first_name' => Crypt::encrypt('User'),
            'last_name' => Crypt::encrypt('test'),
            'access_level' => '3',
            'username' => 'customer@demo.com',
            'email' => Crypt::encrypt('customer@demo.com'),
            'password' => Hash::make('customer'),
            'password_updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ]);


        $email_template[] = array(
            'identifier'        => 'forgot-password-template',
            'name'              => ' Reset Password',
            'title'             => ' Reset Password',
            'subject'           => ' Reset Password',
            'content'           => 'Hello!
                                    You are receiving this email because we received a password reset request for your account.
                                    Please click <a href="{{ website_link }}">here</a> to reset your password.
                                    If you did not request a password reset, no further action is required.
                                    Regards,
                                    Admin ',
            'auto_reply'        => '',
            'is_enabled'        => 1,
        );


        $email_template[] = array(
            'identifier'        => 'activate-account-template',
            'name'              => ' Activate Account',
            'title'             => ' Activate Account',
            'subject'           => ' Activate Account',
            'content'           => 'Hello!
                                    You are receiving this email because you registered to our Website.
                                    Please click <a href="{{ website_link }}">here</a> to Activate your account.',
            'auto_reply'        => '',
            'is_enabled'        => 1,
        );

        



        foreach ($email_template as $data)
        {
            CoreEmailTemplate::create($data);
        }



    }
}
