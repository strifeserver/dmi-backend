<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreOtpLog extends Model
{
    use HasFactory;
    protected $fillable = ['otp', 'expiration_at','token','user_id','status'];
}
