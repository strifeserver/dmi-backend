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
            'allow_module' => '1,3,10,13,18',
            'allow_submodule' => '2,4,11,12,14,16,17,19,20,21,22,23',
            'add' => '10,13,18,2,4,11,12,16,17,21,22,23',
            'edit' => '10,13,2,4,11,12,21,22,23',
            'delete' => '10,13,2,4,11,12,21,22,23',
            'import' => '10,13,2,4,11,12',
            'export' => '10,13,2,4,11,12,14,16,17'
        ]);

        DB::table('core_user_levels')->insert([
            'accesslevel_code' => 'administrator',
            'accesslevel' => 'Administrator',
            'allow_module' => '10,13,18',
            'allow_submodule' => '11,12,14,21,22',
            'add' => '11,12,21,22',
            'edit' => '11,12,21,22',
            'delete' => '11,12,21,22',
        ]);

        DB::table('core_user_levels')->insert([
            'accesslevel_code' => 'customer',
            'accesslevel' => 'Customer',
            'allow_module' => '26,27',
            'allow_submodule' => '',
            'add' => '26,27',
            'edit' => '26,27',
            'delete' => '',
        ]);
        
    }
}
