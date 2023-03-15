<?php

namespace App\Repositories;

use App\ContentManagement;
use App\Repository\ContentManagementRepositoryInterface;
use App\Services\AuditService;
use App\Services\DataStatusService;

class ContentManagementRepository implements ContentManagementRepositoryInterface
{
    protected $contentManagement;
    public function __construct(ContentManagement $contentManagement, AuditService $auditService, DataStatusService $dataStatusService)
    {
        $this->db_table = $contentManagement;
        $this->auditService = $auditService;
        $this->dataStatusService = $dataStatusService;
    }

    
    public function getContentByMultipleKey(array $parameters)
    {
        $contentTitle = @$parameters['content_title'];
        $contentCategory = @$parameters['content_category'];
        $contentTags = @$parameters['content_tags'];

        $getData = $this->db_table->where('content_status', '=', 1)
            ->when($contentTitle, function ($query, $contentTitle) {
                if ($contentTitle != '') {
                    return $query->where('content_title', 'LIKE', '%' . $contentTitle . '%');
                }
            })->when($contentCategory, function ($query, $contentCategory) {
            if ($contentCategory != '') {
                return $query->where('content_category', '%' . $contentCategory . '%');
            }
        })->when($contentTags, function ($query, $contentTags) {
            if ($contentTags != '') {
                return $query->where('content_tags', '%' . $contentTags . '%');
            }
        });
        $getData = $getData->get();
        return $getData;
    }

    public function store($request)
    {
        $execute = false;
        $id = ($request['id']) ?? '';
        $fields = $this->db_table->getFillable();

        if (is_array($request)) {
            $request = collect($request);
        }

        $submittedData = $request->only($fields);
        $after_create = $submittedData->toArray();
        $submittedData = $submittedData->toArray();
        $execute = $this->db_table->create($submittedData)->id;
        $auditing = $this->auditService->auditing($submittedData, []);
        $status['auditDetails'] = $auditing;

        $executeStatus = ($execute) ? 1 : 0;
        $status = array_merge($status, $this->dataStatusService->data_status($executeStatus));
        return $status;
    }

    public function update($request)
    {
        $execute = false;
        $id = ($request['id']) ?? '';
        $fields = $this->db_table->getFillable();
        if (is_array($request)) {
            $request = collect($request);
        }
        if (!empty($id)) {

            $data = $this->db_table->when($id, function ($query, $id) {
                $identifier = explode('-', $id);

                $towhere = 'id';
                if (!empty($id)) {
                    $query->where($towhere, '=', $id);
                }
                return $query;
            })->first();
            if ($data) {
                try {
                    $submittedData = $request->only($fields);
                } catch (\Throwable $th) {
                    $submittedData = $request;
                    array_splice($submittedData, 0, 1);
                }
                $before_update = $data->toArray();
                $submittedData = $submittedData->toArray();
                $execute = $data->update($submittedData);
                $auditing = $this->auditService->auditing($submittedData, $before_update);
                $status['auditDetails'] = $auditing;
            } else {
                $status['remarks'] = 'Data does not exist';
            }
        }
        $executeStatus = ($execute) ? 1 : 0;
        $status = array_merge($status, $this->dataStatusService->data_status($executeStatus));
        return $status;
    }

}
