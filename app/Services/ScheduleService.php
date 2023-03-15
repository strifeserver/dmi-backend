<?php

namespace App\Services;

use App\ScheduleList;
use App\Services\ApiService;
use App\Services\AuditTrailService;
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
