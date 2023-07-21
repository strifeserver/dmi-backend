<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymentSettingService
{

    public function payment_auth_settings()
    {
        $returns = [];
        $authorization = 'Basic c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU46c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU4=';
        $accept = 'application/json';
        $contentType = 'application/json';

        $returns = [
            'Accept' => $accept,
            'Authorization' => $authorization,
            'Content-Type' => $contentType,
        ];
        return $returns;
    }

    public function create_paymongo_link($payMongoValue, $description, $remarks)
    {
        $returns = [];

        $returns = [];
        $authorizationKey = 'c2tfdGVzdF93WnJ5c25DZ1lVNXJVQnZZYjFFY1JwMU46';

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authorization' => 'Basic ' . $authorizationKey,
            'content-type' => 'application/json',
        ])
            ->post('https://api.paymongo.com/v1/sources', [
                'data' => [
                    'attributes' => [
                        'amount' => $payMongoValue,
                        // 'amount' => 10000,
                        'redirect' => [
                            'failed' => url('/paymongo_cancel'),
                            'success' => url('/paymongo_success'),
                        ],
                        'type' => 'gcash',
                        'currency' => 'PHP',
                    ],
                ],
            ]);
        $status_code = $response->status();
        $response = $response->json();

        $returns['status'] = 200;
        $returns['body'] = $response;
        return $returns;

        $paymentSettings = $this->payment_auth_settings();

        $data = [
            'data' =>
            [
                'attributes' => [
                    'amount' => $payMongoValue,
                    'description' => $description,
                    'remarks' => $remarks,
                ],
            ],
        ];

        // $response = Http::withHeaders($paymentSettings)->post('https://api.paymongo.com/v1/links', $data);
        // $body = json_decode($response->body(),true);
        // $status = $response->status();
        // $errorRes = $body['errors'] ?? [];
        // $formattedErrors = [];
        // if(!empty($errorRes)){
        //     foreach ($errorRes as $key => $value) {
        //         $formattedErrors[] = $value;
        //     }
        // }
        // if($status == 200){
        //     $body = $body['data'];
        // }

        // $returns['status'] = $status;
        // $returns['body'] = $body;
        // $returns['errors'] = $formattedErrors;
        // return $returns;

    }

}
