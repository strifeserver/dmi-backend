<?php

namespace App\Services;
use App\Repositories\UserRepository;
use App\Services\AuditService; ##AUDITING / COMMON
use App\Services\DataStatusService; ## STATUS RETURNS / COMMON
use App\Services\Google2faService;
use App\CoreSystemStatus;
// use App\Services\UserLevelService;
use App\User;

class UserService
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }



    public function pageVariables($editData = []){
        $returns = [];
        $google2fa = app(Google2faService::class);
        $google2fa_secret = $editData['google2fa_secret'] ?? ''; 
        $google2faImage = $google2fa->generateQrImage($google2fa_secret);
        $accessLevels = app(UserLevelService::class)->getAllUserLevels();
        $systemStatuses = CoreSystemStatus::all();
        $returns['data']['system_statuses'] = $systemStatuses;
        $returns['data']['access_levels'] = $accessLevels;
        $returns['data']['google2fa'] = $google2faImage['data'];
        return $returns;
    }
    public function UserInformation(){
        $returns = [];
        $LoggedUser = $this->repository->UserInformation();
        if($LoggedUser){
            $accessLevel = app(UserLevelService::class)->getUserLevelById($LoggedUser->access_level);
            if($accessLevel){
                $accessLevelId = $accessLevel->id;
                $accessLevelTitle = $accessLevel->accesslevel;
                $LoggedUser->access_level_id = $accessLevelId;
                $LoggedUser->access_level = $accessLevelTitle;
            }
            $returns['status'] = 'success';
            $returns['data'] = $LoggedUser;
        }
        return $returns;
    }
    public function update($request)
    {
        // Process Data
        $update = $this->repository->update($request);
        return $update;
    }

}
