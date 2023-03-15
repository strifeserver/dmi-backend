<?php

namespace App\Interfaces;

interface SettingInterface
{
    public function update($request);
    public function store($request);
    public function getBySettingName(string $settingName);
    public function getGeneralSettings();
}