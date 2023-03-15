<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model; // <- added this
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CoreNavigationsSeeder::class,
            CoreGeneralSettingsSeeder::class,
            CoreUserLevelsSeeder::class,
            CoreUsersSeeder::class,
            CoreStatusesSeeder::class,
            CoreAuditTrailSeeder::class,
        ]);
    }
}
