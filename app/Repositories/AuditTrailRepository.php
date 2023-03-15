<?php

namespace App\Repositories;

use App\AuditTrail;
use App\Interfaces\AuditTrailInterface;
use App\Services\AccountService;

class AuditTrailRepository implements AuditTrailInterface
{
    /**
     * @param AuditTrail $db
     */
    public $errors = [];
    public function __construct(AuditTrail $db)
    {
        $this->db_table = $db;
    }

    /**
     * @return array
     * @param array $data
     */
    public function index(array $data): array
    {
        $returns = [];
        $errs = [];
        $items_per_page = @$data['items_per_page'];
        $pagination = @$data['pagination'];
        $headers = @$data['headers'];

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
                        if (!empty($value->filter)) {
                            $fields = $this->db_table->getFillable();
                            $blocked_fields = ["remarks","created_at", "updated_at"];
                            foreach ($fields as $field_key => $field_value) {
                                if (!in_array($field_value, $blocked_fields)) {

                                    switch ($field_value) {
                                        case 'created_by':
                                        case 'updated_by':
                                        case 'user_hash':
                                            $account_service = app(AccountService::class);
                                            $fetch = $account_service->edit($value->filter);
                    
                                            if ($fetch['status'] == 'success') {
                                                $hash = '%'.$fetch['result']['hash'].'%';
                                                
                                                if ($count == 0) {
                                                    $query->where($field_value, 'LIKE', $hash);
                                                } else {
                                                    $query->Orwhere($field_value, 'LIKE', $hash);
                                                }
                                                $count++;
                                            }
                                            break;

                                        default:
                                            if ($count == 0) {
                                                $query->where($field_value, 'LIKE', '%' . $value->filter . '%');
                                               
                                            } else {
                                                $query->Orwhere($field_value, 'LIKE', '%' . $value->filter . '%');
                                            }
                                            $count++;
                                            break;
                                    }

                                }
                            }
                        }
                        break;
                    case 'created_at':
                    case 'updated_at':
                        $validator = 0;

                        // try {
                        $from = date('Y-m-d', strtotime($value->from));
                        $to = date('Y-m-d', strtotime($value->to));
                        if (!empty($value->from) && !empty($value->to)) {
                            $validator = 1;
                            $from = $from . ' 00:00:00';
                            $to = $to . ' 23:59:59';
                        }
                        if ($validator == 1) {
                            $query->whereBetween($key, [$from, $to]);
                        } else {
                            $this->errors['remarks'][$key] = 'invalid format: FROM:' . @$value->from . ' TO:' . @$value->to;
                        }
                        // } catch (\Throwable $th) {

                        // }
                        break;
                    case 'created_by':
                    case 'updated_by':
                        $account_service = app(AccountService::class);
                        $fetch = $account_service->edit($value->filter);

                        if ($fetch['status'] == 'success') {
                            $hash = '%'.$fetch['result']['hash'].'%';

                            $query->where($key, '=', $hash);
                        } else {
                            $this->errors['remarks'][$key] = 'no user found ' . @$value->filter;
                            $query->where($key, '=', $value->filter);
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
        })->when($headers, function ($query, $headers) {
            $query->select($headers);
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
        $returns['message'] = @$this->errors['remarks'];
        return $returns;
    }

    /**
     * @return array
     * @param array $request
     */
    public function store(array $request): array
    {

        $returns = [];
        $execute = false;
        $id = ($request['id']) ?? '';
        $fields = $this->db_table->getFillable();

        if (is_array($request)) {
            $request = collect($request);
        }

        $submittedData = $request->only($fields);
        $submittedData = $submittedData->toArray();

        $execute = $this->db_table->create($submittedData)->id;

        $executeStatus = ($execute) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data_id'] = $execute;
        return $returns;
    }

    /**
     * @return array
     * @param integer $id
     */
    public function edit($id): array
    {
        $returns = [];
        $identifiers = ['id', 'log_id'];
        $displayableFields = [];
        $search_vals = ['identifiers' => $identifiers, 'value' => $id];

        $execute = $this->db_table->when($search_vals, function ($query, $search_vals) {
            $fields = $search_vals['identifiers'];
            $id_value = $search_vals['value'];

            foreach ($fields as $key => $value) {
                if ($key == 0) {
                    $query->where($value, '=', $id_value)->first();
                } else {
                    $query->Orwhere($value, '=', $id_value)->first();
                }
            }

            return $query;
        })->first();
        if ($execute) {
            $execute = $execute->toArray();
        }
        $executeStatus = ($execute) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data'] = @$execute;
        return $returns;
    }

    /**
     * @return void
     */
    public function fillables()
    {
        return $this->db_table->getFillable();
    }

    public function last_inserted_id()
    {
        $last_id = $this->db_table->count();

        $last_id = @$last_id ?? 1;
        $last_id = $last_id + 1;

        return $last_id;
    }

}
