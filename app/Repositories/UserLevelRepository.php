<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserLevelInterface;
use App\Services\AuditService;
use App\Services\DataStatusService;
use App\CoreUserLevel;

class UserLevelRepository implements UserLevelInterface
{
    protected $db;
    public function __construct(CoreUserLevel $db, AuditService $auditService, DataStatusService $dataStatusService)
    {
        $this->db_table = $db;
        $this->auditService = $auditService;
        $this->dataStatusService = $dataStatusService;
    }
    public function getUserLevelById(int $id){
        return $this->db_table->where('id',$id)->first();
    }
    public function getAllUserLevels(){
        return $this->db_table->get();
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
