<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;




    public function store(array $request): array
    {
        $returns = [];
        $id = optional($request)->get('id', '');
        $fields = $this->fillable;
    
        $submittedData = collect($request)->only($fields)->toArray();
    
        $execute = $this->db_table::create($submittedData)->id;
    
        $executeStatus = ($execute === true) ? 1 : 0;
        $returns['status'] = $executeStatus;
        $returns['data_id'] = $execute;
    
        return $returns;
    }



}
