<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CoreUserLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_user_levels')->insert([
            'accesslevel_code' => 'developer',
            'accesslevel' => 'Developer',
            'allow_module' => '1,3,10,13,19,22,18',
            'allow_submodule' => '2,4,11,12,14,15,16,17,20,21,23',
            'add' => '10,13,22,18,2,4,11,12,16,17,21,23',
            'edit' => '10,13,22,2,4,11,12,21,23',
            'delete' => '10,13,22,2,4,11,12,21,23',
            'import' => '10,13,2,4,11,12',
            'export' => '10,13,2,4,11,12,14,15,16,17'
        ]);

        DB::table('core_user_levels')->insert([
            'accesslevel_code' => 'administrator',
            'accesslevel' => 'Administrator',
            'allow_module' => '10',
            'allow_submodule' => '11,12',
            'add' => '11,12',
            'edit' => '11,12',
            'delete' => '11,12',
        ]);

        DB::table('core_user_levels')->insert([
            'accesslevel_code' => 'user',
            'accesslevel' => 'User'
        ]);
        
    }
}
