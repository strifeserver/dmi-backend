<?php

namespace App\Repository;

use App\ContentManagement;
use App\Repository\ContentManagementRepositoryInterface;
use App\Services\AuditService;
use App\Services\DataStatusService;
use DB;
class ContentManagementRepository implements ContentManagementRepositoryInterface
{
    protected $contentManagement;
    public function __construct(ContentManagement $contentManagement, AuditService $auditService, DataStatusService $dataStatusService)
    {
        $this->db_table = $contentManagement;
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
        $sort_validator = true;
        // if (empty($sort) || empty($sort['created_at'])) {
        //     $sort_validator = true;
        // }
        // if(!empty($sort['content_schedule'])){
        //     $sort_validator = false;
        // }
        
        if($sort_validator){
            $sort['content_schedule'] = ['sort_by' => 'descending'];
        }
    //     print_r($sort);
    //    exit;
        $execute = $this->db_table->when($filter, function ($query, $filterModel) {
            // Dynamic Column Filtering
            $query->where('content_status', '=', '1');
            foreach ($filterModel as $key => $value) {
                switch ($key) {
                    case 'all':
                        $count = 0;
                        $fields = $this->db_table->getFillable();
                        $attributes = ['fields'=>$fields,'search_value'=>$value->filter];
                        $query->where(function ($query) use ($attributes) 
                        {
                            $fields = $attributes['fields'];
                            $search_value = $attributes['search_value'];
                            foreach ($fields as $field_key => $field_value) {
                                $query->Orwhere($field_value, 'LIKE', '%' . $search_value . '%');
                            }

                        });
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
                        switch ($key) {
                            // case 'content_schedule':
                            //     $query->orderBy(DB::raw("DATE_FORMAT(".$key.",'%d-%M-%Y')"), 'ASC');
                            //     break;
                            default:
                                $query->orderBy($key, 'ASC');
                                break;
                        }
                        break;
                    case 'descending':

                        switch ($key) {
                            // case 'content_schedule':
                            //     $query->orderBy(DB::raw("DATE_FORMAT(".$key.",'%d-%M-%Y')"), 'DESC');
                            //     break;
                            default:
                                $query->orderBy($key, 'DESC');
                                break;
                        }

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
                return $query->where('content_category','LIKE', '%' . $contentCategory . '%');
            }
        })->when($contentTags, function ($query, $contentTags) {
            if ($contentTags != '') {
                return $query->where('content_tags','LIKE', '%' . $contentTags . '%');
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
