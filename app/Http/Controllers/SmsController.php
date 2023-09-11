<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;

class SmsController extends Controller
{

    public function SmsProcess(request $request){



        $SmsService = app(SmsService::class);
        

        $mobile_number = '09282876925';
        $message = 'I just sent my first priority message with Semaphore';
        $data = [
            'mobile_number' => $mobile_number,
            'message' => $message,
        ];
    
        $SmsService = $SmsService->smsSend($data);


    }
}
