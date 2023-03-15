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
use Helper;
use App\Support\AgGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class ContentManagementController extends Controller implements Paginatable
{
    use AcceptsPagination;

    public function __construct(PageService $pageService, AuthService $authService, ContentManagementService $contentManagementService, ContentManagement $db_table)
    {
        $this->db_table = $db_table;
        $this->pageService = $pageService;
        $this->authService = $authService;
        $this->contentManagementService = $contentManagementService;
    }

    public function getColumns(): array
    {
        $access_level = (object) $this->authService->crud_guards();
        if ($access_level->index) {
            $table_cols = $this->table_columns();
            $formatted_cols = [];
            $formatted_cols[] = AgGrid::hidden('id');
            foreach ($table_cols as $key => $value) {
                $table_name = $value['table_name'];
                $table_headername = ($value['headerName']) ? $value['headerName'] : null;
                $is_display = $value['is_display'];
                $is_widen = $value['is_widen'];

                $column_width = $value['column_width'];

                $arr_counter = count($formatted_cols);
                $to_insert = '';

                if ($is_display == true) {
                    if ($column_width == 'W_SMALL') {
                        $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_SMALL);
                    }
                    if ($column_width == 'W_MEDIUM') {
                        $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_MEDIUM);
                    }
                    if ($column_width == 'W_WIDE') {
                        $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_WIDE);
                    }
                    if ($column_width == 'W_ULTRAWIDE') {
                        $to_insert = AgGrid::column($table_name, $table_headername, AgGrid::W_ULTRAWIDE);
                    }
                } else {
                    $to_insert = AgGrid::hidden($table_name);
                }
                $formatted_cols[] = $to_insert;
            }

            return $formatted_cols;
        } else {
            return abort(404);
        }

    }

    // DATA FILTERING AND PAGINATION

    public function getPage(int $start, int $end, ?array $sortModel, ?object $filterModel): PageData
    {
        $rows = $this->db_table->select()
            ->when($filterModel, function ($query, $filterModel) {
                foreach ($filterModel as $key => $value) {
                    if ($key == 'created_at') {
                        $created_at = explode(" to ", $filterModel->created_at->filter);
                        $format_date = $this->filter_date_format_v2($created_at[0], $created_at[1]);
                        $from = $format_date['from'];
                        $to = $format_date['to'];
                        $query->whereBetween('created_at', [$from, $to]);
                    } else {
                        $query->where($key, 'LIKE', '%' . $value->filter . '%');
                    }
                }
                return $query;
            })
            ->paginate($end)
            ->toArray();
        $total = $rows['total'];
        $data = $rows['data'];
        $data = $this->change_value($data);

        return new PageData(
            $total,
            $data
        );
    }

    public function controller_variables()
    {
        $accesslevel = $this->authService->crud_guards();
        $controller_res = [];
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE
        $controller_res['site_title'] = 'Content Management';
        $controller_res['folder_name'] = 'content_management';
        $controller_res['accesslevel'] = $accesslevel;
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE

        return $controller_res;
    }

    public function table_columns()
    {
        // DEFINE YOUR TABLE COLUMN DISPLAY HERE
        $table_col_display = [];
        $table_col_display[] = ['table_name' => 'content_title', 'headerName' => 'TITLE', 'is_display' => true, 'is_widen' => true, 'column_width' => 'W_WIDE'];
        $table_col_display[] = ['table_name' => 'content_category', 'headerName' => 'CATEGORY', 'is_display' => true, 'is_widen' => true, 'column_width' => 'W_WIDE'];
        $table_col_display[] = ['table_name' => 'content_status', 'headerName' => 'STATUS', 'is_display' => true, 'is_widen' => true, 'column_width' => 'W_WIDE'];
        $table_col_display[] = ['table_name' => 'created_at', 'headerName' => 'DATE CREATED', 'is_display' => true, 'is_widen' => true, 'column_width' => 'W_ULTRAWIDE'];
        $table_col_display[] = ['table_name' => 'updated_at', 'headerName' => 'DATE UPDATED', 'is_display' => true, 'is_widen' => true, 'column_width' => 'W_ULTRAWIDE'];
        return $table_col_display;
    }

    public function index()
    {

        // // FILTER DATA
        $statuses = [['status_name' => 'Active','value' => '1'], ['status_name' => 'Inactive','value' => '0']];
        $filters = [
            ['filter_name' => 'Page Status', 'filter_code' => 'content_status', 'filter_type' => 'dropdown_filter', 'dropdown_data' => $statuses],
            ['filter_name' => 'Date Filter', 'filter_code' => 'created_at', 'filter_type' => 'date_filter', 'dropdown_data' => null], #sample_date filter
        ];
        // // FILTER DATA

        $table_version = 'v2';
        $table_version_file = 'default';
        #v1 - load all data, frontend filtering
        #v2 - backend filtering data
        #table_version_file
        #default - using v1 and v2 js file
        #mixed - same file with v1 and v2 switchable tables

        if ($table_version == 'v1') {
            $return_data = $this->table_v1()['return_data'];
            $controls_btn_index = $this->table_v1()['controls_btn_index'];
        }

        $page_variables = $this->pageService->page_variables([
            'mode' => 'index',
            'agrid_data' => @$return_data,
            'data_filters' => $filters,
            'controller_variables' => $this->controller_variables(),
        ]);

        # ADD PARAMS HERE TO FURTHER ADD RETURNS
        $page_variables['static'] = [
            'title' => $page_variables['title'],
            'controls' => $page_variables['controls'],
            'columns' => $this->getColumns(),
            'pagination_link' => url('paginate/' . $page_variables['folder_name']),
            'agrid_data' => ($table_version == 'v1') ? $return_data : null,
            'data_filters' => $filters,
            'page' => $page_variables['page'],
            'controls_btn_index' => @$controls_btn_index,
            'routes' => [
                $page_variables['folder_name'] . '.edit' => route($page_variables['folder_name'] . '.edit', ':id'),
                $page_variables['folder_name'] . '.destroy' => route($page_variables['folder_name'] . '.destroy', ':id'),
            ],
            'table_version' => $table_version, #v1 v2 options
            'table_version_file' => $table_version_file, #v1 v2 options

        ];

        return view($page_variables['index_page'], $page_variables);
    }

    public function change_value($rows)
    {
        $search_array = $rows;
        foreach ($search_array as $key => $value) {
            if (Arr::exists($value, 'status')) {
                if ($value['status'] === 1) {
                    $value['status'] = 'Active';
                }
                if ($value['status'] === 0) {
                    $value['status'] = 'Inactive';
                }
            }
        }
        return $search_array;
    }

    public function create()
    {


        $cm_categories = ['highlight','gallery','event','link','sermon', 'visit','ministry', 'newsletter', 'sunday school', 'roots and wings', 'world bible college', 'testimonial', 'leadership', 'resources'];
        $app_env = config('app.app_env');
        $image_init_url = '';
        if($app_env == 'production'){
            $image_init_url = '/api';
        }else{
            $image_init_url = '';
        }
    
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
        $page_variables['static']['cm_categories'] = $cm_categories;
        $page_variables['static']['image_init_url'] = @$image_init_url;
        return view($page_variables['create_page'], $page_variables);

    }

    public function store(ContentMangementPostRequest $request)
    {

        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
        $validated = $request->validated();
        $execution = $this->contentManagementService->store($validated);

        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Created ' . $execution['message']
            );
    }

    public function edit($id)
    {
        $cm_categories = ['highlight','gallery','event','link','sermon', 'visit','ministry', 'newsletter', 'sunday school', 'roots and wings', 'world bible college', 'testimonial', 'leadership', 'resources'];
        $app_env = config('app.app_env');
        $image_init_url = '';
        if($app_env == 'production'){
            $image_init_url = '/api';
        }else{
            $image_init_url = '';
        }
        $ctrl_var = $this->controller_variables();
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $edit = $this->db_table->findOrFail($id);
        $page_variables['edit'] = $edit;
        $page_variables['static']['cm_categories'] = $cm_categories;
        $page_variables['static']['image_init_url'] = @$image_init_url;

        $content_description_raw = json_decode($edit['content_description'],true);
        if($content_description_raw){
            $edit->sub_content_section = @$content_description_raw['sub_content_section'];
            $edit->content_description = @$content_description_raw['content_description'];
            $edit->content_invitation = @$content_description_raw['content_invitation'];
            $edit->content_footer = @$content_description_raw['content_footer'];
        }
        return view($page_variables['edit_page'], $page_variables);
    }

    public function update(ContentMangementPostRequest $request)
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $validated = $request->validated();
        $execution = $this->contentManagementService->update($validated);
        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Updated ' . $execution['message']
            );
    }

    public function destroy($db_table)
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'index']);
        $db_table = $this->db_table->findOrFail($db_table);

        $auditing = ['data_id' => $db_table->id, 'data' => $db_table];

        $saving = $db_table->delete();
        if ($saving) {
            $core_audit_trail = $this->audit_trail('', 'DELETE', $auditing, $db_table->id);
            $return_msg = ['type' => 'success', 'remarks' => 'Successfully Deleted'];
        } else {
            $return_msg = ['type' => 'error_comment', 'remarks' => 'Failed to Delete'];
        }
        return redirect()->route($page_variables['destroy_page'])->with($return_msg['type'], $return_msg['remarks']);
    }

    public function preview_template(Request $request)
    {
        $content = $request->input('content');
        $returns = [];
        $html = '';

        $returns['fullMesg'] = $content;

        $html .= view('pages.temp_previews.preview', $returns)->render();

        return $html;
    }

    public function getContents(request $request){
        $parameters = [];
        $parameters['content_title'] = @request('content_title');
        $parameters['content_category'] = @request('content_category');
        $parameters['content_tags'] = @request('content_tags');
        $execution = $this->contentManagementService->getContents($parameters);
        if($execution){
            try {
                $execution = $execution->toArray();
            } catch (\Throwable $th) {
            }
        }
        $return = $this->api_return($execution);
        return $return;
    }


    public function api_index()
    {
        $returns = [];
        $modi_ret = [];
        $execution = $this->contentManagementService->index();


        $returns = $execution;
        $code = $returns['code'] ?? 400;
        return response($returns, $code)->header('Content-Type', 'application/json');
    }

}
