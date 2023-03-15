<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailOutbox extends Model
{
    protected $fillable = ["send_to","cc_to","template_id","subject","content","raw_content","status","created_by","updated_by"];

    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s', strtotime($value));
    }
    #Fetch user info
    public function getUserHashAttribute($value)
    {
        if (!empty($value)) {
            $account_service = app(AccountService::class);
            $fetch = $account_service->edit($value);
            if ($fetch['status'] == 'success') {
                $value = $fetch['result']['name'];
            }
        }
        return $value;
    }
    public function getCreatedByAttribute($value)
    {
        if (!empty($value)) {
            $account_service = app(AccountService::class);
            $fetch = $account_service->edit($get_user_hash);
            if ($fetch['status'] == 'success') {
                $value = $fetch['result']['name'];
            }
        }
        return $value;
    }
    public function getUpdatedByAttribute($value)
    {
        if (!empty($value)) {
            $account_service = app(AccountService::class);
            $fetch = $account_service->edit($get_user_hash);
            if ($fetch['status'] == 'success') {
                $value = $fetch['result']['name'];
            }
        }
        return $value;
    }
}
