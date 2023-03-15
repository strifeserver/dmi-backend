<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
            'first_name' => Crypt::encrypt('User'),
            'last_name' => Crypt::encrypt('test'),
            'access_level' => '3',
            'username' => 'user@demo.com',
            'email' => Crypt::encrypt('website_user@email.com'),
            'password' => Hash::make('user'),
            'password_updated_at' => Carbon::now()->format('Y-m-d H:i:s')

        ]);





    }
}
