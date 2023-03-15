<?php
namespace App\Http\Controllers;

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
    public static function cmp($a, $b)
    {
        return strcmp($a->name, $b->name);
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // FIXME: Use global functions for duplicate codes
        // TODO: Provide Guard and policy middlewware as well
        \View::composer('*', function ($view) {
            config(['app.timezone' => 'Asia/Taipei']);
            $_user = request()->user();
            if (!$_user) {
                return;
            }
            $navigations = DB::table('core_navigations')->get();
            $userLevel = DB::table('core_user_levels')->find($_user->access_level);
            // collect allowed navigation ids:
            $allowedModules = [];
            // FIXME: Duplicates
            if ($userLevel->allow_module) {
                $c = explode(',', $userLevel->allow_module);
                foreach ($c as $i) {
                    $allowedModules[$i] = true; // dummy
                }
            }

            if ($userLevel->allow_submodule) {
                $c = explode(',', $userLevel->allow_submodule);
                foreach ($c as $i) {
                    $allowedModules[$i] = true; // dummy
                }
            }

            $navs = json_decode($navigations, true);

            $menu = array('menu' => array());
            foreach ($navs as $key => $value) {
                // ignore if not on allowed modules
                if (!isset($allowedModules[$value['id']])) {
                    continue;
                }
                if ($value['nav_status'] == 1) {
                    if ($value['nav_type'] == 'main' || $value['nav_type'] == 'single') {
                        $isActive = $value['nav_mode'] &&
                            (request()->is($value['nav_mode']) || request()->is($value['nav_mode'] . '/*'));

                        $menu['menu'][$key]['id'] = $value['id'];
                        $menu['menu'][$key]['url'] = $value['nav_mode'];
                        $menu['menu'][$key]['name'] = $value['nav_name'];
                        $menu['menu'][$key]['icon'] = $value['nav_icon'];
                        $menu['menu'][$key]['nav_order'] = $value['nav_order'];
                        $menu['menu'][$key]['active'] = $isActive;

                        if ($value['nav_type'] == 'main') {
                            $menu['menu'][$key]['submenu'] = array();

                            foreach ($navs as $keya => $sub_nav) {
                                if ($sub_nav['nav_type'] == 'sub') {

                                    if ($value['id'] == $sub_nav['nav_parent_id']) {
                                        $isActive = $sub_nav['nav_mode'] &&
                                            (request()->is($sub_nav['nav_mode']) || request()->is($sub_nav['nav_mode'] . '/*'));

                                        $submenu = array(
                                            'id' => $sub_nav['id'],
                                            'url' => $sub_nav['nav_mode'],
                                            'name' => $sub_nav['nav_name'],
                                            'icon' => $sub_nav['nav_icon'],
                                            'nav_suborder' => $sub_nav['nav_suborder'],
                                            'active' => $isActive);
                                        if (!isset($allowedModules[$sub_nav['id']])) {
                                            continue;
                                        }

                                        $sub_sub_menu_count = 0;
                                        foreach ($navs as $keyaa => $sub_sub_nav) {
                                            if ($sub_sub_nav['nav_type'] == 'sub_sub') {
                                                if ($sub_sub_nav['nav_parent_id'] == $sub_nav['id']) {

                                                    $isActive = $sub_sub_nav['nav_mode'] && (request()->is($sub_sub_nav['nav_mode']) || request()->is($sub_sub_nav['nav_mode'] . '/*'));
                                                    $sub_sub_menu_count++;
                                                    $sub_submenu = array(
                                                        'id' => $sub_sub_nav['id'],
                                                        'url' => $sub_sub_nav['nav_mode'],
                                                        'name' => $sub_sub_nav['nav_name'],
                                                        'icon' => $sub_sub_nav['nav_icon'],
                                                        'nav_suborder' => $sub_sub_nav['nav_suborder'],
                                                        'active' => $isActive);
                                                    $submenu['submenu'][] = $sub_submenu;
                                                }

                                            }
                                        }

                                        $menu['menu'][$key]['submenu'][] = $submenu;
                                        if ($isActive) {
                                            $menu['menu'][$key]['active'] = $isActive;
                                            foreach ($menu['menu'][$key]['submenu'] as $keysubmenu => $subactive) {
                                                if ($sub_sub_nav['id'] == $subactive['id']) {
                                                    // $menu['menu'][$key]['submenu'][$keysubmenu]['active'] = $isActive;
                                                }
                                            }
                                        }
                                    }

                                }

                            }

                        }
                        if ($value['nav_type'] == 'single') {
                            $menu['menu'][$key]['url'] = $value['nav_mode'];
                            $menu['menu'][$key]['name'] = $value['nav_name'];
                            $menu['menu'][$key]['icon'] = $value['nav_icon'];
                            $menu['menu'][$key]['nav_order'] = $value['nav_order'];
                        }

                    }

                    if ($value['nav_type'] == 'main') {
                        usort($menu['menu'][$key]['submenu'], function ($first, $second) {
                            return strtolower($first['nav_suborder']) > strtolower($second['nav_suborder']);
                        });
                    }
                }
            }
            $sortedScores = Arr::sort($menu['menu'], function ($nav) {
                return $nav['nav_order'];
            });
            $menu['menu'] = $sortedScores;
            $verticalMenuJson = json_encode($menu);
            $verticalMenuData = json_decode($verticalMenuJson);
            $view->with('menuData', $verticalMenuData);
        });

    }
}
