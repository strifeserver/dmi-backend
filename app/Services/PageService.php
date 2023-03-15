<?php

namespace App\Services;

use App\Services\AuthService;

class PageService
{

    /**
     *
     */
    protected $db;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function page_variables($data)
    {

        $accesslevel = $this->authService->crud_guards();
       
        // Required Data ------------------------
        $title = $data['controller_variables']['site_title'];
        $mode = $data['mode'];
        $page = $data['controller_variables']['folder_name']; #for create/update page redirects in js
        $folder_name = $data['controller_variables']['folder_name'];
        $static = @$data['controller_variables']['static'];
        // $data['controller_variables']['accesslevel'] = $accesslevel;

        // Required Data ------------------------

        // Not Required Data ------------------------
        $edit = @$data['edit'];
        $agrid_data = @$data['agrid_data'];
        $add_link = $folder_name . '/create'; #for create page link
        // $controls = @$data['controls'];
        $data_filters = @$data['data_filters'];
        if ($data_filters) {
            $filter_count = count($data_filters);
        } else {
            $filter_count = 0;
        }
        $controls_btn_index = @$data['controls_btn_index'];
        // Not Required Data ------------------------
        $crud_pages = [
            'index_page' => 'pages.' . $folder_name . '.index',
            'create_page' => 'pages.' . $folder_name . '.create',
            'store_page' => '' . $folder_name . '.index',
            'edit_page' => 'pages.' . $folder_name . '.create',
            'update_page' => '' . $folder_name . '.index',
            'destroy_page' => '' . $folder_name . '.index',
        ];

        $mode_check = strtolower($mode);
        if (!$accesslevel['add'] && $mode_check == 'create') {
            return abort(404);
        }
        if (!$accesslevel['edit'] && $mode_check == 'edit') {
            return abort(404);
        }
        if (!$accesslevel['delete'] && $mode_check == 'delete') {
            return abort(404);
        }

        if ($static) {

        }

        $page_variables = [
            'title' => $title,
            'folder_name' => $folder_name,
            'mode' => $mode,
            'edit' => $edit,
            'page' => $page,
            'agrid_data' => $agrid_data,
            'add_link' => $add_link,
            'controls' => $accesslevel,
            'data_filters' => $data_filters,
            'data_filters_a' => json_encode($data_filters),
            'filter_count' => $filter_count,
            'controls_btn_index' => $controls_btn_index,
            'is_import' => false,
            'static' => @$static,

        ];
        $page_res = array_merge($page_variables, $crud_pages);
        return $page_res;
    }

}
