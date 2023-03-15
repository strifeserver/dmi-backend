<?php

namespace App\Services;

use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Repositories\AuditTrailRepository;
use App\Services\ApiService;
use App\Services\ExportService;

class AuditTrailService
{

    /**
     * @param AuditTrailRepository $repository
     */
    public function __construct(AuditTrailRepository $repository, ApiService $api_service)
    {
        $this->repository = $repository;
        $this->api_service = $api_service;
    }

    public function logged_in_user()
    {
        $user_id = Auth::id();

    }

    /**
     * @return array
     * @param integer $id
     */
    public function index(): array
    {

        $data = [];
        $itemsPerPage = request('itemsPerPage') ?? 10;
        $filter = request('filter') ?? [];
        $sort = request('sort') ?? [];
        $pagination = request('pagination');
        if (empty($pagination)) {
            $pagination = 0;
        }

        $data['items_per_page'] = $itemsPerPage;
        $data['filters'] = $filter;
        $data['sort'] = $sort;
        $data['pagination'] = $pagination;
        $execution = $this->repository->index($data);
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    /**
     * @return array
     * @param array $request
     */
    public function store(array $request): array
    {

        $action_dictionary = ['store' => 'ADD', 'update' => 'UPDATE', 'destroy' => 'DELETE'];
        $module_name = $request['module_name'] ?? '';
        $action = $request['method'] ?? '';
        $incoming_data = $request['incoming_data'] ?? [];
        $existing_data = $request['existing_data'] ?? [];
        $details = $request['details'] ?? [];
        $remarks = $request['remarks'] ?? '';
        $user_id = request("hash") ?? '';
        $changes = $request['changes'] ?? [];
        $mode = @$request['mode'] ? 'override' : 'normal';

        #logid
        $last_id = $this->repository->last_inserted_id();
        $log_id = str_pad($last_id, 4, 0, STR_PAD_LEFT);
        $log_id = 'log' . $log_id;
        #logid

        if ($mode == 'normal') {
            #Auto Detect Root Function
            $tracecallbacks = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
            $class = $tracecallbacks['class'];
            $function = $tracecallbacks['function'];

            #Fetch Module Name
            try {
                $module_name = str_replace("App\Services\\", '', $class);
                $module_name = str_replace("Service", '', $module_name);
                $module_name = preg_replace("([A-Z])", " $0", $module_name);
                $module_name = trim($module_name);
            } catch (\Throwable $th) {
                $module_name = $class;
            }

            #Identify Method
            try {
                $action = $action_dictionary[$function];
            } catch (\Throwable $th) {
                $action = '';
            }
            if (!empty($existing_data)) {
                try {
                    $incoming_data['model'] = json_encode($incoming_data['model']);
                    $existing_data['model'] = json_encode($existing_data['model']);
                    $changes = array_diff($incoming_data, $existing_data);
                } catch (\Throwable $th) {

                }

            }
        }

        $insert = [
            'log_id' => $log_id,
            'module' => $module_name,
            'action_taken' => $action,
            'before_changes' => $existing_data,
            'after_changes' => $incoming_data,
            'details' => $details,
            'remarks' => $remarks,
            'changes' => $changes,
            'user_hash' => $user_id,
            'created_by' => $user_id,
            'updated_by' => $user_id,
        ];

        $execution = $this->repository->store($insert);
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    /**
     * @return array
     * @param integer $Id
     */
    public function edit(int $Id): array
    {
        $execution = $this->repository->edit($Id);
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    /**
     * @return void
     */
    public function fillables()
    {
        $execution = $this->repository->fillables();
        return $execution;
    }

    public function export($data)
    {

        $returns = ['status' => 0];
        $get_data = [];
        $get_data['filters'] = $data->filter ?? '';
        $get_data['headers'] = $data->header ?? [];
        $rows = [];
        $row_count = 0;
        $execution = $this->repository->index($get_data);
        if (!empty($execution)) {
            $rows = $execution['data'];
            $row_count = count($rows);
        }

        $exportService = app(ExportService::class);
        $unique_id = Str::random(5);
        $import_mode = 'audit_trail';
        $filename = $import_mode . '_export_' . $unique_id . '_' . date('Y-m-d');
        $headers = $data['headers'] ?? $this->fillables();

        $data = [
            'filename' => $filename,
            'mode' => $import_mode,
            'headers' => $headers,
            'rows' => $rows,
        ];
        if ($row_count > 0) {
            $exporting = $exportService->create($data);
            if ($exporting['status'] == 'success') {
                $returns['status'] = 1;
                $returns['data']['export_file_csv'] = url('/') . '/storage/' . $filename . '.csv';
            }
        } else {
            $returns['status'] = 1;

            // $returns['result']['export_result'] = 'no data found';
        }
        $returns = $this->api_service->api_returns($returns);

        return $returns;
    }

}
