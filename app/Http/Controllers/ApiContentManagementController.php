<?php

namespace App\Http\Controllers;

use App\ContentManagement;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination\AcceptsPagination;
use App\Http\Controllers\Pagination\PageData;
use App\Http\Controllers\Pagination\Paginatable;
use App\Http\Requests\ContentMangementPostRequest;
use App\Services\AuthService;
use App\Services\ContentManagementService;
use App\Services\PageService;
use App\Support\AgGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ApiContentManagementController extends Controller
{
    public function __construct(ContentManagementService $contentManagementService)
    {
        $this->contentManagementService = $contentManagementService;
    }

    public function getContentsManagement(Request $request)
    {
        // optional parameters
        #content_title
        #content_category
        #content_tags
        // optional parameters
        $parameters = $this->decv2($request->input('d'));
        $getContents = $this->contentManagementService->getContents($parameters);
        $return = $this->api_return($getContents);
        return $return;
    }




}
