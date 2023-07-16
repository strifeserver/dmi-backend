<?php

namespace Database\Seeders;

use App\CoreNavigation;
use Illuminate\Database\Seeder;

class CoreNavigationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // GUIDE
        // FIRST LEVEL DROPDOWN NAV
        // [
        //     'main' => [ 'MAIN NAV NAME', '', '', 'ICON','NAV STATUS'],
        //     'sub' => [
        //         [ 'SUB NAV NAME', 'SUB URL NAME', '(SUB CONTROLLER NAME)Controller', 'SUB ICON','SUB NAV STATUS'],
        //         [ 'SUB NAV NAME', 'SUB URL NAME', '(SUB CONTROLLER NAME)Controller', 'SUB ICON','SUB NAV STATUS'],
        //     ]
        // ],

        $config = [

            [
                'main' => ['Dashboard', '', '', 'feather icon-home', '1', 'main'],
                'sub' => [
                    ['Graphs', 'app-email', 'CoreDashboards', 'feather icon-circle', '1', 'sub'],
                ],
            ],

            [
                'main' => ['Settings', '', '', 'feather icon-settings', '1', 'main'],
                'sub' => [
                    ['General Settings', 'general_settings', 'Setting', 'feather icon-circle', '1', 'sub'],
                    ['Navigation Settings', 'navigations', 'CoreNavigations', 'feather icon-circle', '1', 'sub'],
                    ['Group Settings', 'group_settings', 'CoreGroupSettings', 'feather icon-circle', '1', 'sub'],
                    ['Console Group', 'console_group', 'CoreGroupConsole', 'feather icon-circle', '1', 'sub'],
                    ['Sub Group', 'sub_groups', 'CoreSubGroups', 'feather icon-circle', '1', 'sub'],
                    ['Controllers', 'controllers', 'CoreControllers', 'feather icon-circle', '1', 'sub'],
                ],
            ],

            [
                'main' => ['User Management', '', '', 'feather icon-user', '1', 'main'],
                'sub' => [
                    ['User', 'users', 'Users', 'feather icon-circle', '1', 'sub'],
                    ['User Level', 'user_levels', 'CoreUserLevels', 'feather icon-circle', '1', 'sub'],
                ],
            ],

            [
                'main' => ['System Logs', '', '', 'feather icon-database', '1', 'main'],
                'sub' => [
                    ['Audit Trail', 'audit_trail_logs', 'CoreAuditTrailLogs', 'feather icon-circle', '1', 'sub'],
                    ['API Logs', 'api_logs', 'APILogs', 'feather icon-circle', '1', 'sub'],
                    ['Email Outbox', 'email_outbox', 'EmailOutboxes', 'feather icon-circle', '1', 'sub'],
                    ['imports', 'imports', 'CoreImport', 'feather icon-circle', '3', 'sub'],
                ],
            ],

            // [
            //     'main' => [ 'Calendar', 'calendars', 'CoreCalendars', 'feather icon-home','1','single'],
            // ],

            [
                'main' => ['Maintenance', '', '', 'feather icon-settings', '1', 'main'],
                'sub' => [
                    ['Images', 'images', 'CoreImages', 'feather icon-circle', '1', 'sub'],
                    ['Content', 'content_management', 'ContentManagement', 'feather icon-circle', '1', 'sub'],
                    ['Survey', 'surveys', 'Survey', 'feather icon-circle', '1', 'sub'],
                    ['Transactions', 'transactions', 'Transactions', 'feather icon-circle', '1', 'sub'],
                    ['Workers', 'workers', 'Workers', 'feather icon-circle', '1', 'sub'],
                ],
            ],
            [
                'main' => ['Templates', '', '', 'feather icon-settings', '1', 'main'],
                'sub' => [
                    ['Email Templates', 'email_template', 'EmailTemplates', 'feather icon-circle', '1', 'sub'],
                ],
            ],
            [
                'main' => [ 'Survey History', 'survey_history', 'SurveyHistory', 'feather icon-home','1','single'],
            ],
            [
                'main' => [ 'Transaction History', 'transaction_history', 'TransactionHistory', 'feather icon-home','1','single'],
            ],

        ];

        $this->createNavigations($config);
    }

    private function createNavigations($config)
    {
        for ($i = 0; $i < sizeof($config); ++$i) {
            // create main nav

            $nav = $config[$i];
            $parent = [
                'nav_name' => $nav['main'][0],
                'nav_mode' => $nav['main'][1],
                'nav_controller' => $nav['main'][2],
                'nav_icon' => $nav['main'][3],
                'nav_type' => $nav['main'][5],
                'nav_order' => $i + 1,
                'nav_suborder' => 0,
                'nav_parent_id' => 0,
                'nav_status' => $nav['main'][4],
            ];

            $parentId = CoreNavigation::insertGetId($parent);

            // create sub navigations
            if (!empty($nav['sub'])) {

                for ($j = 0; $j < sizeof($nav['sub']); ++$j) {

                    $child = [
                        'nav_name' => $nav['sub'][$j][0],
                        'nav_mode' => $nav['sub'][$j][1],
                        'nav_controller' => $nav['sub'][$j][2],
                        'nav_icon' => $nav['sub'][$j][3],
                        'nav_type' => $nav['sub'][$j][5],
                        'nav_order' => 0,
                        'nav_suborder' => $j + 1,
                        'nav_parent_id' => $parentId,
                        'nav_status' => $nav['sub'][$j][4],
                    ];

                    CoreNavigation::insert($child);
                }
            }
        }

    }

}
