<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\AccountService;
use Route;
class AuditTrail extends Model
{
    protected $fillable = ["id","log_id","module","action_taken","before_changes","after_changes","changes","details","remarks","user_hash","created_at","updated_at"];

    public function setBeforeChangesAttribute($value){
        $this->attributes['before_changes'] = json_encode($value);
    }
    public function setAfterChangesAttribute($value){
        $this->attributes['after_changes'] = json_encode($value);
    }
    public function setDetailsAttribute($value){
        $this->attributes['details'] = json_encode($value);
    }
    public function setChangesAttribute($value){
        $this->attributes['changes'] = json_encode($value);
    }
    public function getBeforeChangesAttribute($value){
        $route = route::current()->uri;
        $checkroutes = ['api/admin/audit_trails/export','api/admin/audit_trails_test/export','api/admin/audit_trails_data/export'];
        if(!in_array($route,$checkroutes)){
            $value = json_decode($value);
        }
        return $value;
    }
    public function getAfterChangesAttribute($value){
        $route = route::current()->uri;
        $checkroutes = ['api/admin/audit_trails/export','api/admin/audit_trails_test/export','api/admin/audit_trails_data/export'];
        if(!in_array($route,$checkroutes)){
            $value = json_decode($value);
        }
        return $value;
    }
    public function getDetailsAttribute($value){
        $route = route::current()->uri;
        $checkroutes = ['api/admin/audit_trails/export','api/admin/audit_trails_test/export','api/admin/audit_trails_data/export'];
        if(!in_array($route,$checkroutes)){
            $value = json_decode($value);
        }
        return $value;
    }
    public function getChangesAttribute($value){
        $route = route::current()->uri;
        $checkroutes = ['api/admin/audit_trails/export','api/admin/audit_trails_test/export','api/admin/audit_trails_data/export'];
        if(!in_array($route,$checkroutes)){
            $value = json_decode($value);
        }
        return $value;
    }

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
        $get_user_hash = $this->attributes['user_hash'];
        if (!empty($get_user_hash)) {
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
        $get_user_hash = $this->attributes['user_hash'];
        if (!empty($get_user_hash)) {
            $account_service = app(AccountService::class);
            $fetch = $account_service->edit($get_user_hash);
            if ($fetch['status'] == 'success') {
                $value = $fetch['result']['name'];
            }
        }
        return $value;
    }
    public function getActionTakenAttribute($value)
    {
        $value = $value.' '.$this->attributes['module'];
        return $value;
    }

}
