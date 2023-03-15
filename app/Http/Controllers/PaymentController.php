<?php

namespace App\Http\Controllers;

use App\Services\PaymentSettingService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function __construct(PaymentSettingService $paymentSetting)
    {
        $this->paymentSetting = $paymentSetting;
    }

    public function create_payment_link(PaymentRequest $request)
    {
        // The expected amount that the link should receive. A positive integer with a minimum amount of 100. 100 is the smallest unit in cents. If you want the link to receive an amount of 1.00, the value that you should pass is 100. If you want the link to receive an amount of 1500.50, the value that you should pass is 150050.

        $validated = $request->validated();
        $returns = [];
        // inputs
        $userPayAmount = $validated['payment_amount'];
        $description = $validated['description'] ?? '';
        $remarks = $validated['remarks'] ?? '';
        // inputs
        
        $payMongoConverter = 100;
        $payMongoValue = $userPayAmount * $payMongoConverter;

        $createLink = $this->paymentSetting->create_paymongo_link($payMongoValue, $description, $remarks);
        if($createLink['status'] == 200){
            $checkoutUrl = @$createLink['body']['attributes']['checkout_url'];
            if(!empty($checkoutUrl)){
                $returns['checkout_url'] = @$checkoutUrl;
                $returns['reference_number'] = @$createLink['body']['attributes']['reference_number'];
                $returns['status'] = 1;

            }
        }else{
            $returns['errors'] = $createLink['errors'];
        }
        return $returns;
    }



}
