<?php

namespace App\Interfaces;

interface EmailTemplateInterface
{
    public function update($request);
    public function store($request);
}