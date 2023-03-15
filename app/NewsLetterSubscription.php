<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetterSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['email','status'];
    public function setStatusAttribute($value)
    {
        if(empty($value) && $value != 0){
            $this->attributes['status'] = 1;
        }else{
            $this->attributes['status'] = 0;
        }
    }

}
