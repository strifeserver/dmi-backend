<?php

namespace App\Services;

use App\ScheduleList;
use App\Services\ApiService;
use App\Services\AuditTrailService;
use App\Services\SurveyService;
use Helper;

class ScheduleService
{
/**
 * @param ScheduleList $repository
 * @param ApiService $api_service
 * @param AuditTrailService $audit_service
 */
    public function __construct(ScheduleList $repository, ApiService $api_service)
    {
        $this->repository = $repository;
        $this->api_service = $api_service;
    }

/**
 * @param integer $id
 * @return array
 */
    public function index($paramData): array
    {

        $itemsPerPage = request('itemsPerPage', 10);
        $filter = @$paramData['filters'] ?? request('filter', []);
        $pagination = request('pagination', 0);
        $display_fields_only = $paramData['display_fields_only'] ?? null;

        $data = [
            'pagination' => $pagination,
            'items_per_page' => $itemsPerPage,
            'filters' => $filter,
            'display_fields_only' => $display_fields_only,
        ];
        $execution = $this->repository->index($data);
        $response = Helper::apiResponse($execution['status'], 200, null, $execution['data']);
        return $response;
    }

/**
 * @param array $request
 * @return array
 */
    public function store(array $request): array
    {
        if (!empty($request['survey_id'])) {
            if (!is_int($request['survey_id'])) {
                $SurveyService = app(SurveyService::class);
                $indexParams = ['filter' => json_encode(['survey_id' => ['filter' => $request['survey_id']]])];
                $surveySearch = $SurveyService->index($indexParams);
                if (!empty($surveySearch['result'])) {
                    $request['survey_id'] = $surveySearch['result'][0]['id'];
                }
            }
        }

        $execution = $this->repository->execute_store($request);

        if ($execution['status'] === 1) {
            $audit_data = ['incoming_data' => $request];
        }

        $response = $this->api_service->api_returns($execution);

        return $response;
    }

/**
 * @param integer $Id
 * @return array
 */
    public function edit(int $Id): array
    {
        $execution = $this->repository->edit($Id);
        $response = $this->api_service->api_returns($execution);

        return $response;
    }

/**
 * @param array $request
 * @return array
 */
    public function update(array $request): array
    {
        if (!is_integer($request['survey_id'])) {
            $SurveyService = app(SurveyService::class);
            $indexParams = ['filter' => json_encode(['survey_id' => ['filter' => $request['survey_id']]])];
            $surveySearch = $SurveyService->index($indexParams);
            // $request['survey_id'] = $surveySearch['id'];
            if (!empty($surveySearch['result'])) {
                $surveySearch = $surveySearch['result'][0];
                $request['survey_id'] = $surveySearch['id'];

                if (!empty($request['classes'])) {
                    $structure = [
                        'id' => $surveySearch['id'],
                    ];

                    switch ($request['classes']) {
                        case 'chip+chip-success':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'finished',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);

                            break;
                        case 'chip+chip-warning':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'pending',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);
                            break;
                        case 'chip+chip-danger':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'rejected',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);
                            break;

                        case 'chip+chip-blue':
                        case 'chip+chip-primary':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'process',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);
                            break;

                        default:
                            # code...
                            break;
                    }
                }

           
            }
        }

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
            $formatted[key($value)] = ['filter' => current($value)];
        }

        $data = ['filters' => json_encode($formatted)];
        $execution = $this->repository->index($data);

        $execution['data'] = (count($execution['data']) == 1) ? $execution['data'][0] : $execution['data'];

        $response = $this->api_service->api_returns($execution);
        return $response;
    }

}
