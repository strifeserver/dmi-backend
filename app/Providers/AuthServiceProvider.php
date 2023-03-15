<?php

namespace App\Providers;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Gate::define('index', $this->_generateGuard('index'));
        Gate::define('add', $this->_generateGuard('add'));
        Gate::define('edit', $this->_generateGuard('edit'));
        Gate::define('delete', $this->_generateGuard('delete'));
        Gate::define('import', $this->_generateGuard('import'));
        Gate::define('export', $this->_generateGuard('export'));
    }

    /**
     * Determines if the action is allowed for the current user
     * Resolves the current module using the current path
     *
     * @param  [type] $action  add|edit|delete|import|export
     * @param  [type] $navMode [description]
     * @return [type]          [description]
     */
    private function _generateGuard($action) {
        return function($user) use ($action) {
            // path1/path2
            $path = request()->path();
            if($action == 'index'){
                $indexpath = explode('/', $path);
                if(!empty($indexpath[1])){
                    $path = $indexpath[1];
                }
            }
            
            // if($path == '/')
            //     return false;
            // use 1st element in path
            $navMode = explode('/', $path)[0];
            $module = \DB::table('core_navigations')
                ->where('nav_mode', $navMode)
                    ->orWhere('nav_mode', '/' . $navMode)
                ->value('id');
            
            if(!$module)
                return Response::deny("Module ${navMode} is not listed");
              
            // $userlevel := <action> => "module-id, module-id"
          
            if($action == 'index'){
                $userLevel = \DB::table('core_user_levels')
                ->select('allow_module','allow_submodule')
                ->find($user->access_level);
               
                // Single Nav
                $uslvl_action = $userLevel->allow_module; 
                $allowAdd = $uslvl_action ? explode(',', $uslvl_action) : [];
                $isAllowed = in_array($module, $allowAdd);
                // Single Nav
                if(!$isAllowed){
                    $uslvl_action = $userLevel->allow_submodule; 
                    $allowAdd = $uslvl_action ? explode(',', $uslvl_action) : [];
                    $isAllowed = in_array($module, $allowAdd);
                }
                return $isAllowed;
                
            }else{
                $userLevel = \DB::table('core_user_levels')
                ->select($action)
                ->find($user->access_level);
                $uslvl_action = $userLevel->$action;
            }
         
           
            $allowAdd = $uslvl_action ? explode(',', $uslvl_action) : [];
            $isAllowed = in_array($module, $allowAdd);
            return $isAllowed;
        };
    }
}
