<?php

namespace App\Repositories;

use App\NewsLetterSubscription;
use App\Interfaces\NewsletterSubscriptionRepositoryInterface;
use App\Services\AuditService;
use App\Services\DataStatusService;

class NewsletterSubscriptionRepository implements NewsletterSubscriptionRepositoryInterface
{
    protected $db_table;
    public function __construct(NewsLetterSubscription $db_table, AuditService $auditService, DataStatusService $dataStatusService)
    {
        $this->db_table = $db_table;
        $this->auditService = $auditService;
        $this->dataStatusService = $dataStatusService;
    }


    public function index(array $data): array
    {
        $returns = [];
        $items_per_page = @$data['items_per_page'];
        $pagination = @$data['pagination'];

        $filter = @json_decode($data['filters']) ?? [];
        $sort = @json_decode($data['sort'], true) ?? [];

        #default newest_to_oldest
        if (empty($sort) || empty($sort['created_at'])) {
            $sort['created_at'] = ['sort_by' => 'descending'];
        }
        
        $execute = $this->db_table->when($filter, function ($query, $filterModel) {
            // Dynamic Column Filtering
            foreach ($filterModel as $key => $value) {
                switch ($key) {
                    case 'all':
                        $count = 0;
                        $fields = $this->db_table->getFillable();
                        foreach ($fields as $field_key => $field_value) {
                            if ($count == 0) {
                                $query->where($field_value, 'LIKE', '%' . $value->filter . '%');
                            } else {
                                $query->Orwhere($field_value, 'LIKE', '%' . $value->filter . '%');
                            }
                            $count++;
                        }
                        break;
                    case 'created_at';
                        try {
                            $from = date('Y-m-d', strtotime($value->from));
                            $to = date('Y-m-d', strtotime($value->to));
                            $from = $from . ' 00:00:00';
                            $to = $to . ' 23:59:59';
                            $query->whereBetween('created_at', [$from, $to]);
                        } catch (\Throwable $th) {

                        }
                        break;
                    case 'updated_at';
                        try {
                            $from = date('Y-m-d', strtotime($value->from));
                            $to = date('Y-m-d', strtotime($value->to));
                            $from = $from . ' 00:00:00';
                            $to = $to . ' 23:59:59';
                            $query->whereBetween('updated_at', [$from, $to]);
                        } catch (\Throwable $th) {

                        }
                        break;
                    default:
                        $query->where($key, 'LIKE', '%' . $value->filter . '%');
                        break;
                }
            }
            return $query;
        })->when($sort, function ($query, $sortModel) {
            // Dynamic Column Sorting
            foreach ($sortModel as $key => $value) {
                switch ($value['sort_by']) {
                    case 'ascending':
                        $query->orderBy($key, 'ASC');
                        break;
                    case 'descending':
                        $query->orderBy($key, 'DESC');
                        break;
                }
            }
            return $query;
        });
        try {
            if ($pagination == 1) {
                $execute = $execute->paginate($items_per_page)->toArray();
            } else {
                $execute = $execute->get()->toArray();
            }
            $executionResult = 1;
        } catch (\Throwable $th) {
            $executionResult = 0;
        }

        $executeStatus = ($executionResult) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data'] = @$execute;
        return $returns;
    }


    public function subscribe($request)
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

    public function unsubscribe($request)
    {
        $execute = false;
        $id = ($request['id']) ?? $request['email'];
        $fields = $this->db_table->getFillable();
        if (is_array($request)) {
            $request = collect($request);
        }
     
            $data = $this->db_table->when($id, function ($query, $id) {
                $identifier = explode('-', $id);

                $towhere = 'email';
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
       
        $executeStatus = ($execute) ? 1 : 0;
        $status = array_merge($status, $this->dataStatusService->data_status($executeStatus));
        return $status;
    }

}
