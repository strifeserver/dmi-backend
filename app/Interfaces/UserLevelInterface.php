<?php

namespace App\Interfaces;

interface UserLevelInterface
{
    public function update($request);
    public function store($request);
    public function getUserLevelById(int $id);
}