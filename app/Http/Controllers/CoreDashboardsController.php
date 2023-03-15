<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class CoreDashboardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routen =Route::getFacadeRoot()->current()->uri();

        switch ($routen) {
            case 'dashboard':
            $pageConfigs = [
                'pageHeader' => false
            ];

            return view('/pages/dashboard-ecommerce', [
                'pageConfigs' => $pageConfigs
            ]);
            break;

            default:
            return view('.pages.landing_page', [
            ]);
            break;
        }

    }




}
