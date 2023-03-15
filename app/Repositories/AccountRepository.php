<?php

namespace App\Repositories;

use App\User;
use App\Interfaces\AccountInterface;

class AccountRepository implements AccountInterface
{
    public function __construct(User $db)
    {
        $this->db_table = $db;
    }

    /**
     * @return array
     * @param array $request
     */
    public function update(array $request): array
    {
        $returns = [];
        $execute = false;
        $id = ($request['id']) ?? '';
        $identifiers = ['hash','email'];
        $fields = $this->db_table->getFillable();

        if (is_array($request)) {
            $request = collect($request);
        }
        
        if (!empty($id)) {
            $data = $this->db_table->where($identifiers[0], '=', $id)->first();
           
            if ($data) {
                $submittedData = $request->only($fields);
                $beforeUpdate = $data->toArray();
                $submittedUpdate = $submittedData->toArray();
                $execute = $data->update($submittedUpdate);
                $auditing = null; // no update auditing defined
            } else {
                $returns['result'] = 'data does not exist';
            }

        }
        
        $executeStatus = ($execute) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data_id'] = @$data->id;
        return $returns;

    }

    /**
     * @return array
     * @param integer $id
     */
    public function edit($id): array
    {
        $returns = [];
        $identifiers = ['email_address','hash','name','username'];
        $displayableFields = [];
        $fields = ['id','username','email_address','name','hash','updated_at'];
        $search_vals = ['identifiers'=>$identifiers,'value'=>$id];
        $execute = $this->db_table->select($fields)->when($search_vals, function ($query, $search_vals) {
            $fields = $search_vals['identifiers'];
            $id_value = $search_vals['value'];

         
            foreach ($fields as $key => $value) {
                $id_value = '%'.$id_value.'%';
                if($key == 0){
                    $query->where($value, 'LIKE',$id_value)->first();
                }else{
                    $query->Orwhere($value, 'LIKE',$id_value)->first();
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



}
