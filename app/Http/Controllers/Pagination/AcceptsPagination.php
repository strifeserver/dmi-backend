<?php

namespace App\Http\Controllers\Pagination;

use Illuminate\Http\Request;

/**
 * @see PaginationHelper.php
 */
trait AcceptsPagination
{
    /**
     * Entry point for http calls to <url>/pagination/<nav_mode>
     *
     * TODO:
     * Auto apply start and end
     * separate transform method (create method on interface)
     */
    public function acceptPagination(Request $request)
    {
        return response()->json(
            $this->getPage($request->start ?? 0,
                $request->end ?? 0,
                json_decode($request->sort),
                json_decode($request->filter)
            )
        );
    }
}
