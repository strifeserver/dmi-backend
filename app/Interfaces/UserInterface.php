<?php

namespace App\Interfaces;

interface UserInterface
{
    public function update($request);
    public function store($request);
}