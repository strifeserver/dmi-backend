<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CoreAuditTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_audit_trail_logs')->insert([
            'module' => 'Core',
            'username' => 'Laravel System',
            'action_taken' => 'System Seed',
            'remarks' => 'Seed Success',
            'ip' => 'n/a'
        ]);     
    }
}
