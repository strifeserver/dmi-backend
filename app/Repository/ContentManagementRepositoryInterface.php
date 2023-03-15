<?php

namespace App\Repository;

interface ContentManagementRepositoryInterface
{
    public function update($request);
    public function store($request);
    public function getContentByMultipleKey(array $parameters);
}