<?php

namespace App\Http\Controllers\Pagination;

use Illuminate\Support\Facades\Route;

class PaginationHelper
{
    const ROUTE_PREFIX = 'paginate';
    const CONTRACT_ACCEPT_METHOD = 'acceptPagination';

    public static function routes(array $navigations)
    {
        // include routes which are instance of Paginatable
        array_reduce($navigations, function($carry, $item) {
            if(!$item->nav_controller)
                return $carry;

            $classPath = "App\Http\Controllers\\{$item->nav_controller}Controller";

            // implements Pagination/Paginatable ?
            if(is_subclass_of($classPath, Paginatable::class, true)) {
                $uri = sprintf("/%s/%s", self::ROUTE_PREFIX, $item->nav_mode); // e.g. /pagination/users
                $carry[$classPath] = url($uri);

                Route::get($uri, [ $classPath, self::CONTRACT_ACCEPT_METHOD ]);
            }

            return $carry;
        }, []);
    }
}
