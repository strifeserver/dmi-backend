<?php

namespace App\Services;

use App\Repositories\SettingRepository; ## STATUS RETURNS / COMMON

class Google2faService
{
    public function __construct()
    {
        $this->google2fa = app('pragmarx.google2fa');
    }
    public function generateSecretKey()
    {
        return $this->google2fa->generateSecretKey();
    }
    public function google2faSettings()
    {
        $returns = [];
        $settings = app(SettingRepository::class)->getBySettingName('2FA');
        $status = ($settings[0]->setting_value == 'OFF') ? 0 : 1;
        if ($status != 0) {
            $qr_name = $settings[3]->setting_value ?? '';
            $qr_address = $settings[4]->setting_value ?? '';
            $returns['data']['qr_name'] = $qr_name;
            $returns['data']['qr_address'] = $qr_address;
        }
        $returns['data']['status'] = $status;
        return $returns;
    }

    public function generateQrImage($google2fa_secret)
    {
        $returns = [];
        $settings = $this->google2faSettings();
        if ($settings['data']['status'] == 1) {
            $qr_name = $settings['data']['qr_name'];
            $qr_address = $settings['data']['qr_address'];
            $qr_secretkey = (empty($google2fa_secret))  ?  $this->generateSecretKey() : $google2fa_secret;
            $QR_Image = $this->google2fa->getQRCodeInline(
                $qr_name,
                $qr_address,
                $qr_secretkey
            );
            $returns['data']['qr_image'] = $QR_Image;
            $returns['data']['generatedsecret'] = $qr_secretkey;
        }
        $returns['data']['status'] = $settings['data']['status'];
        return $returns;
    }

}
