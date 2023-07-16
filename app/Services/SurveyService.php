<?php

namespace App\Services;

use App\Services\ApiService;
use App\Services\AuditTrailService;
use App\Services\ScheduleService;
use App\Survey;
use Illuminate\Support\Facades\Storage;

class SurveyService
{
/**
 * @param Survey $repository
 * @param ApiService $api_service
 * @param AuditTrailService $audit_service
 */
    public function __construct(Survey $repository, ApiService $api_service)
    {
        $this->repository = $repository;
        $this->api_service = $api_service;
    }

/**
 * @param integer $id
 * @return array
 */
    public function index($data): array
    {

        $itemsPerPage = request('itemsPerPage', 10);
        try {
            $filter = @$data['filter'];

        } catch (\Throwable $th) {
            $filter = request('filter');
        }
        // $filter = @request('filter') ?? @$data['filter'];
        $pagination = request('pagination', 0);
      
        $data = [
            'pagination' => $pagination,
            'items_per_page' => $itemsPerPage,
            'filters' => $filter,
        ];

        $execution = $this->repository->index($data);
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

/**
 * @param array $request
 * @return array
 */
    public function store($request)
    {

        $customer_file_names = [];
        $customer_survey_files_upload = $request['customer_survey_files'];
        if ($customer_survey_files_upload) {
            foreach ($customer_survey_files_upload as $key => $value) {
                $naming_convention = $request['survey_id'];
                $new_file_name = $naming_convention . '_' . $value->getClientOriginalName();
                $path = Storage::putFileAs('customer_survey_files', $value, $new_file_name);
                $customer_file_names[] = $value->getClientOriginalName();
            }
            $request['customer_survey_files'] = json_encode($customer_file_names);

        }

        $execution = $this->repository->store($request);

        if ($execution['status'] === 1) {
            $audit_data = ['incoming_data' => $request];
            // $this->audit_service->store($audit_data);
        }

        $response = $this->api_service->api_returns($execution);
        return $response;
    }

/**
 * @param integer $Id
 * @return array
 */
    public function edit($Id): array
    {

        $execution = $this->repository->edit($Id);
        $response = $this->api_service->api_returns($execution);
        $ScheduleService = app(ScheduleService::class);

        $paramData = ['filters' => ['survey_id' => $response['result']['id']]];
        $fetchSchedule = $ScheduleService->index($paramData);
        if ($fetchSchedule) {
            $new_customer_survey_files = [];
            $response['result']['schedule'] = $fetchSchedule['result'][0]['date'];
            $customer_survey_files = $response['result']['customer_survey_files'];
            try {
                //code...
                $customer_survey_files = json_decode($customer_survey_files);
                foreach ($customer_survey_files as $key => $value) {
                    $new_customer_survey_files[] = url('/') . '/customer_survey_files/' . $response['result']['survey_id'] . '_' . $value;
                }
                $response['result']['customer_survey_files'] = $new_customer_survey_files;
            } catch (\Throwable $th) {
                //throw $th;
            }

        }

        return $response;
    }

/**
 * @param array $request
 * @return array
 */
    public function update(array $request): array
    {
        $execution = $this->repository->execute_update($request);
        $response = ['status' => $execution['status'], 'data_id' => $execution['data_id'], 'message' => ''];
        return $response;
    }

/**
 * @param integer $id
 * @return array
 */
    public function destroy(int $id): array
    {
        $existing_data = $this->edit($id);
        $execution = $this->repository->destroy($id);

        if ($execution['status'] === 1 && $existing_data) {
            $existing_data = $existing_data['result']->toArray() ?? $existing_data['result'];
            $audit_data = ['existing_data' => $existing_data];
            // $this->audit_service->store($audit_data);
        }

        $response = $this->api_service->api_returns($execution);

        return $response;
    }

/**
 * @return void
 */
    public function fillables(): void
    {
        $this->repository->fillables();
    }

    public function find_data($find)
    {
        $formatted = [];
        foreach ($find as $key => $value) {
            $switchKey = key($value);
            $formatted[key($value)] = ['filter' => current($value)];

        }

        $data = ['filters' => json_encode($formatted)];
        $execution = $this->repository->index($data);

        $execution['data'] = (count($execution['data']) == 1) ? $execution['data'][0] : $execution['data'];

        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    public function analyticsFilterDates($request)
    {
        $selectedOption = $request;
        $to = date('Y-m-d');

        $options = [
            date('Y-m-d', strtotime('-7 days')),
            date('Y-m-d', strtotime('-28 days')),
            date('Y-m-d', strtotime('-60 days')),
            date('Y-m-d', strtotime('-360 days')),
        ];
        # 0 - last 7 days
        # 1 - last 28 days
        # 2 - last month
        # 3 - last year
        $from = $options[$selectedOption];

        return ['from' => $from, 'to' => $to];
    }

}
