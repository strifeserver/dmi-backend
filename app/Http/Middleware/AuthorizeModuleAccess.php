<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeModuleAccess
{
    /**
     * Handle an incoming request.
     * Specifically used for core_navigations
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $moduleId)
    {
        // check if user is authorized
        $user = \Auth::user();

        if(!$user) {
            return redirect('/login');
        }

        $access = \DB::table('core_user_levels')->find($user->access_level);
        $allowedModules = $access->allow_module ? explode(',', $access->allow_module) : [];
        $allowedSubModules = $access->allow_submodule ? explode(',', $access->allow_submodule): [];

        if(! (in_array($moduleId, $allowedModules) ||
                in_array($moduleId, $allowedSubModules))) {
            abort(404); // Returning 403 would imply that the path does exist
        }

        return $next($request);
    }
}
