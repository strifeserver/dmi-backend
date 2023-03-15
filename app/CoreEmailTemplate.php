<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoreEmailTemplate extends Model
{
    protected $required = ['identifier', 'name', 'title', 'email', 'subject', 'content', 'auto_reply', 'succes_message', 'is_enabled'];

    protected $fillable = ['identifier', 'name', 'title', 'email', 'subject', 'content', 'auto_reply', 'succes_message', 'is_enabled', "created_by", "updated_by"];

    protected $table = 'core_email_templates';

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s', strtotime($value));
    }
    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d h:i:s', strtotime($value));
    }
    #Fetch user info
    public function getCreatedByAttribute($value)
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
    public function getUpdatedByAttribute($value)
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

}
