<?php

namespace App\Services;
use App\Repositories\EmailTemplateRepository;

class EmailTemplateService
{
    public function __construct(EmailTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function pageVariables($editData = []){
        $returns = [];

        return $returns;
    }
    public function UserInformation(){

    }
    public function update($request)
    {
        // Process Data
        $update = $this->repository->update($request);
        return $update;
    }

}
