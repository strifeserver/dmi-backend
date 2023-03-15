<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreSetting extends Model
{
    use HasFactory;


    protected $table = 'core_settings';
    protected $fillable = ['setting_name', 'setting_value', 'setting_description', 'category'];

    public function getCreatedAtAttribute($value) {
        if(!empty($value)){
            return date('m-d-Y', strtotime($value));
        }
    }
    public function getUpdatedAtAttribute($value) {
        if(!empty($value)){
            return date('m-d-Y', strtotime($value));
        }
    }
}
