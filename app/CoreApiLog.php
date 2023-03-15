<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreApiLog extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($value) {
        if($value){
            return date('m-d-Y h:i:s A', strtotime($value));
        }else{
            return 'Invalid Date';
        }
    }
    public function getUpdatedAtAttribute($value) {
        if($value){
            return date('m-d-Y h:i:s A', strtotime($value));
        }else{
            return 'Invalid Date';
        }
    }
    public function getStatusAttribute($value) {
        if($value == '1'){
            return 'Active';
        }else if($value == '0'){
            return 'Inactive';
        }
    }
}
