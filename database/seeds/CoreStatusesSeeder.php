<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CoreStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_system_statuses')->insert([
            'status_name' => 'Active'
        ]);  

        DB::table('core_system_statuses')->insert([
            'status_name' => 'Inactive'
        ]); 

        DB::table('core_system_statuses')->insert([
            'status_name' => 'Expired'
        ]); 

        DB::table('core_system_statuses')->insert([
            'status_name' => 'Lock'
        ]); 
    }
}
