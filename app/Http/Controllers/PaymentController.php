<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Services\PaymentSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



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
        if ($createLink['status'] == 200) {
            $checkoutUrl = @$createLink['body']['attributes']['checkout_url'];
            if (!empty($checkoutUrl)) {
                $returns['checkout_url'] = @$checkoutUrl;
                $returns['reference_number'] = @$createLink['body']['attributes']['reference_number'];
                $returns['status'] = 1;

            }
        } else {
            $returns['errors'] = $createLink['errors'];
        }
        return $returns;
    }

    public function initiateGCashPayment(Request $request)
    {
        $paymentAmount = 2000; // Replace with the actual payment amount

        // $response = Http::withHeaders([
        //     'Authorization' => 'Basic c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU46c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU4=',
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json',
        // ])->post('https://api.paymongo.com/v1/payments', [
        //     'data' => [
        //         'attributes' => [
        //             'amount' => $paymentAmount,
        //             'currency' => 'PHP',
        //             'payment_method_allowed' => ['gcash'],
        //             'description' => 'Payment for order #123', // Replace with your order description
        //             'statement_descriptor' => 'MyBusinessName',
        //         ],
        //         // 'relationships' => [
        //             // 'source' => [
        //             //     'id' => 'payment_sources11',
        //             //     'data' => [
        //             //         'type' => 'payment_sources',
        //             //         'attributes' => [
        //             //             'type' => 'gcash',
        //             //             'type' => 'gcash',
        //             //         ],
        //             //     ],
        //             // ],
        //         // ],
        //     ],
        // ]);


        $response = Http::withHeaders([
            'Authorization' => 'Basic c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU46c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU4=',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.paymongo.com/v1/payments', [
            'data' => [
                'attributes' => [
                    'amount' => $paymentAmount,
                    'currency' => 'PHP',
                    'payment_method_allowed' => ['gcash'],
                    'description' => 'Payment for order #123', // Replace with your order description
                    'statement_descriptor' => 'MyBusinessName',
                    'source' => [
                        'type' => 'source',
                        'id' => 'token',
                    ],
                ],


            ],

        ]);
        



        $paymentData = $response->json();
        print_r($paymentData);
        exit;
        // Redirect the user to the GCash payment URL
        return redirect($paymentData['data']['attributes']['redirect']['checkout_url']);
    }

    public function handleGCashPaymentCallback(Request $request)
    {
        // Handle the callback from PayMongo after the payment is completed
        // You can retrieve the payment status and other details from the request
        $paymentStatus = $request->input('data.attributes.status');

        if ($paymentStatus === 'paid') {
            // Payment is successful
            // Perform any necessary actions (e.g., update order status, send confirmation email, etc.)
        } else {
            // Payment failed or other error occurred
            // Handle the error case appropriately
        }
    }


    public function paymongoGcashInitial(){

        
        // Basic c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU46'

        // Replace 'KEYKEYKEY' with your actual authorization key
        $authorizationKey = 'c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU46';
        
        $response = Http::withHeaders([
                'accept' => 'application/json',
                'authorization' => 'Basic ' . $authorizationKey,
                'content-type' => 'application/json',
            ])
            ->post('https://api.paymongo.com/v1/sources', [
                'data' => [
                    'attributes' => [
                        'amount' => 10000,
                        'redirect' => [
                            'failed' => 'http://127.0.0.1:8000/paymongo_cancel',
                            'success' => 'http://127.0.0.1:8000/paymongo_success',
                        ],
                        'type' => 'gcash',
                        'currency' => 'PHP',
                    ],
                ],
            ]);
        return $response;
        // Handle the response
        if ($response->successful()) {
            // Request was successful
            $responseData = $response->json();
            // Process the $responseData as needed
        } else {
            // Request failed
            $errorCode = $response->status();
            // Handle the error
        }
        





    }

    public function paymongoGcashSuccess(){

        return view('/pages/payment/payment_success', [
        ]);
    }

    public function paymongoGcashCancel(){


    }

}
