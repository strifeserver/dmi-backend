<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pagination\AcceptsPagination;
use App\Http\Controllers\Pagination\PageData;
use App\Http\Controllers\Pagination\Paginatable;
use App\Http\Requests\SurveyPostRequest;
use App\Services\AuthService;
use App\Services\PageService;
use App\Services\ScheduleService;
use App\Services\SurveyService;
use App\Support\AgGrid;
use App\Survey;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SurveyController extends Controller implements Paginatable
{
    use AcceptsPagination;

    public function __construct(PageService $pageService, AuthService $authService, ScheduleService $ScheduleService, SurveyService $SurveyService, Survey $db_table)
    {
        $this->db_table = $db_table;
        $this->pageService = $pageService;
        $this->authService = $authService;
        $this->SurveyService = $SurveyService;
        $this->ScheduleService = $ScheduleService;
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
                $is_widen = @$value['is_widen'];

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
        $controller_res['site_title'] = 'Survey';
        $controller_res['folder_name'] = 'surveys';
        $controller_res['accesslevel'] = $accesslevel;
        #UPDATE ON EACH CONTROLLER YOU MAKE WITH TABLE

        return $controller_res;
    }

    public function table_columns()
    {
        return [
            ['table_name' => 'survey_id', 'headerName' => 'SURVEY ID', 'is_display' => true, 'column_width' => 'W_WIDE'],
            ['table_name' => 'name', 'headerName' => 'NAME', 'is_display' => true, 'column_width' => 'W_WIDE'],
            ['table_name' => 'email_address', 'headerName' => 'EMAIL ADDRESS', 'is_display' => true, 'column_width' => 'W_ULTRAWIDE'],
            ['table_name' => 'created_at', 'headerName' => 'DATE CREATED', 'is_display' => true, 'column_width' => 'W_WIDE'],
            ['table_name' => 'updated_at', 'headerName' => 'DATE UPDATED', 'is_display' => true, 'column_width' => 'W_WIDE'],
        ];
    }

    public function index()
    {

        // // FILTER DATA
        $statuses = [['status_name' => 'Active', 'value' => '1'], ['status_name' => 'Inactive', 'value' => '0']];
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
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
        return view($page_variables['create_page'], $page_variables);
    }

    public function store(SurveyPostRequest $request)
    {

        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Create']);
        $validated = $request->validated();
        $execution = $this->SurveyService->store($validated);

        return redirect()
            ->route($page_variables['update_page'])
            ->with(
                $execution['status'],
                $page_variables['title'] . ' Created ' . $execution['message']
            );
    }

    public function edit($id)
    {
        $ctrl_var = $this->controller_variables();
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $edit = $this->db_table->findOrFail($id);
        $page_variables['edit'] = $edit;

        return view($page_variables['edit_page'], $page_variables);
    }

    public function update(SurveyPostRequest $request)
    {
        $page_variables = $this->pageService->page_variables(['controller_variables' => $this->controller_variables(), 'mode' => 'Update']);
        $validated = $request->validated();

        $execution = $this->SurveyService->update($validated);
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

    public function api_index()
    {
        $returns = [];
        $modi_ret = [];
        $execution = $this->SurveyService->index();

        $returns = $execution;
        $code = $returns['code'] ?? 400;
        return response($returns, $code)->header('Content-Type', 'application/json');
    }
    public function scheduled_dates()
    {
        $returns = [];
        $check_schedule_data = [
            'display_fields_only' => ['date'],
        ];
        $check_schedule = $this->ScheduleService->index($check_schedule_data);

        $returns = $check_schedule;
        $code = $returns['code'] ?? 400;
        return response($returns, $code)->header('Content-Type', 'application/json');
    }

    public function create_survey(request $request)
    {

        $check_schedule_data = [
            'filters' => ['date' => ['filter' => $request['requested_schedule'], 'type' => 'same_day']],
        ];
        $check_schedule = $this->ScheduleService->index($check_schedule_data);
        if (!empty($check_schedule['result'])) {
            $response = Helper::apiResponse('error', 400, 'Failed to create survey');
      
        } else {
            // create survey
            $survey_id = $this->generateTicket();
            $to_validate = [
                'survey_id' => $survey_id,
                'name' => request('name'),
                'address' => request('address'),
                'email_address' => request('email_address'),
                'mobile_number' => request('mobile_number'),
                'customer_survey_files' => request('customer_survey_files'),
            ];
            $execution = $this->SurveyService->store($to_validate);

            $to_validate = [
                'survey_id' => $execution['result']['id'],
                'requested_by' => request('name'),
                'approved_by' => request('approved_by'),
                'schedule_raw' => date(request('requested_schedule')),
                'date' => date(request('requested_schedule')),
                // 'schedule_raw' => date('2023-02-20'),
                // 'date' => date('2023-02-20'),
                'time' => null,
                'status' => 1,
            ];
            $createSchedule = $this->ScheduleService->store($to_validate);

            if ($execution['status'] == 'success' && $createSchedule['status'] == 'success') {
                $response = Helper::apiResponse('success', 200, 'Survey Successfully Created', ['survey_id' => $survey_id,'debug'=>json_encode($check_schedule)]);
            } else {
                $response = Helper::apiResponse('error', 400, 'Failed to create survey');
            }
            
        }

        return response()->json($response);
    }

    public function generateTicket($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ticket = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $ticket .= $characters[$index];
        }
        $ticket .= time(); // Add current timestamp to the end of the ticket
        return $ticket;
    }

    public function track_survey(request $request)
    {

        $survey_id = $request['survey_id'];
        $trackSurvey = $this->SurveyService->edit($survey_id);
        $trackSurvey = (array) $trackSurvey;

        return response()->json($trackSurvey);
    }

}
