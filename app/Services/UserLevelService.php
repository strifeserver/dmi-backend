<?php

namespace App\Services;
use App\Repositories\UserLevelRepository;
use App\Services\AuditService; ##AUDITING / COMMON
use App\Services\DataStatusService; ## STATUS RETURNS / COMMON
use App\User;

class UserLevelService
{
    public function __construct(UserLevelRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getUserLevelById(int $id){
        return $this->repository->getUserLevelById($id);
    }
    public function getAllUserLevels(){
        return $this->repository->getAllUserLevels();
    }

}
