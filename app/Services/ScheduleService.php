<?php

namespace App\Services;

use App\ScheduleList;
use App\Services\ApiService;
use App\Services\AuditTrailService;
use App\Services\PaymentSettingService;
use App\Services\SurveyService;
use App\Services\TransactionService;
use App\Survey;
use Helper;

class ScheduleService
{
/**
 * @param ScheduleList $repository
 * @param ApiService $api_service
 * @param AuditTrailService $audit_service
 */
    public function __construct(ScheduleList $repository, ApiService $api_service)
    {
        $this->repository = $repository;
        $this->api_service = $api_service;
    }

/**
 * @param integer $id
 * @return array
 */
    public function index($paramData): array
    {

        $itemsPerPage = request('itemsPerPage', 10);
        $filter = @$paramData['filters'] ?? request('filter', []);
        $pagination = request('pagination', 0);
        $display_fields_only = $paramData['display_fields_only'] ?? null;

        $data = [
            'pagination' => $pagination,
            'items_per_page' => $itemsPerPage,
            'filters' => $filter,
            'display_fields_only' => $display_fields_only,
        ];
        $execution = $this->repository->index($data);
        $response = Helper::apiResponse($execution['status'], 200, null, $execution['data']);
        return $response;
    }

/**
 * @param array $request
 * @return array
 */
    public function store(array $request): array
    {
        if (!empty($request['survey_id'])) {
            if (!is_int($request['survey_id'])) {
                $SurveyService = app(SurveyService::class);
                $indexParams = ['filter' => json_encode(['survey_id' => ['filter' => $request['survey_id']]])];
                $surveySearch = $SurveyService->index($indexParams);
                if (!empty($surveySearch['result'])) {
                    $request['survey_id'] = $surveySearch['result'][0]['id'];

                    if (!empty($request['classes'])) {
                        $structure = [
                            'id' => $surveySearch['result'][0]['id'],
                        ];

                        switch ($request['classes']) {
                            case 'chip+chip-success':
                            case 'chip chip-success':
                                $structure['status'] = 'finished';
                                $SurveyUpdate = $SurveyService->update($structure);
                                break;
                            case 'chip+chip-warning':
                            case 'chip chip-warning':
                                $structure['status'] = 'pending';

                                $SurveyUpdate = $SurveyService->update($structure);
                                break;
                            case 'chip+chip-danger':
                            case 'chip chip-danger':
                                $structure['status'] = 'rejected';

                                $SurveyUpdate = $SurveyService->update($structure);
                                break;

                            case 'chip+chip-blue':
                            case 'chip chip-blue':
                            case 'chip+chip-primary':
                            case 'chip chip-primary':
                                $structure = [
                                    'id' => $surveySearch['id'],
                                    'status' => 'process',
                                ];
                                $SurveyUpdate = $SurveyService->update($structure);
                                break;

                        }

                    }

                }
            }
        }
        $getSurveyID = Survey::where('id','=',$request['survey_id'])->first();
        if($getSurveyID){
            $request['survey_tracking_id'] = $getSurveyID->survey_id; 
        }
   
        $execution = $this->repository->execute_store($request);
        // $execution = [
        //     'status' => 1,
        //     'data_id' => 10,
        // ];
        if ($execution['status'] === 1) {
            $audit_data = ['incoming_data' => $request];
        }
        $request['payment_gateway'] = 'paymongo';
        if (isset($request['payment_amount'])) {

            if ($request['payment_gateway'] == 'paymongo') {
                $payment_amount = $request['payment_amount'];
                if ($payment_amount > 100) {
                    $createPaymentLink = $this->create_payment_link($request);
        
                    // $createPaymentLink = [
                    //     'checkout_url' => 'https://pm.link/strifeserver/test/j7Lr371',
                    //     'reference_number' => 'j7Lr371',
                    //     'status' => '1',
                    // ];
              
                    $paymentURL = $createPaymentLink['checkout_url'];

                }
            }

            if ($request['payment_gateway'] == 'paypal') {
                $payment_amount = $request['payment_amount'];
                if ($payment_amount > 100) {
                    $createPaymentLink = $this->create_payment_link($request);
                    // $PaypalResult = [
                    //     "id" => "6XK7750295684622V",
                    //     "status" => "CREATED",
                    //     "links" => [
                    //         [
                    //             "href" => "https://api.sandbox.paypal.com/v2/checkout/orders/6XK7750295684622V",
                    //             "rel" => "self",
                    //             "method" => "GET",
                    //         ],
                    //         [
                    //             "href" => "https://www.sandbox.paypal.com/checkoutnow?token=6XK7750295684622V",
                    //             "rel" => "approve",
                    //             "method" => "GET",
                    //         ],
                    //         [
                    //             "href" => "https://api.sandbox.paypal.com/v2/checkout/orders/6XK7750295684622V",
                    //             "rel" => "update",
                    //             "method" => "PATCH",
                    //         ],
                    //         [
                    //             "href" => "https://api.sandbox.paypal.com/v2/checkout/orders/6XK7750295684622V/capture",
                    //             "rel" => "capture",
                    //             "method" => "POST",
                    //         ],
                    //     ],
                    // ];

                    $paymentURL = $PaypalResult['links'][1];
                }

            }

            if (isset($paymentURL)) {
                $execution['payment'] = $paymentURL;
                $getSurveyInfo = Survey::where('id', '=', $request['survey_id'])->first();
                if ($getSurveyInfo) {
                    $surveyID = $getSurveyInfo['survey_id'];

                }

                $transactionStructure = [
                    'tagged_schedule_id' => $execution['data_id'],
                    'survey_id' => $surveyID,
                    'requested_amount' => $request['payment_amount'],
                    'payment_url' => $paymentURL,
                    'status' => 0,
                ];

                $transactionService = app(TransactionService::class);
                $createTransactionLog = $transactionService->store($transactionStructure);

            }

        }

        $response = $this->api_service->api_returns($execution);

        return $response;
    }

    public function create_payment_link($request)
    {
        // The expected amount that the link should receive. A positive integer with a minimum amount of 100. 100 is the smallest unit in cents. If you want the link to receive an amount of 1.00, the value that you should pass is 100. If you want the link to receive an amount of 1500.50, the value that you should pass is 150050.

        $returns = [];
        // inputs
        $getSurveyInfo = Survey::where('id', '=', $request['survey_id'])->first();

        $userPayAmount = $request['payment_amount'];
        $description = $getSurveyInfo['survey_id'] ?? '';
        $remarks = 'Payment Creation';
        // inputs

        $payMongoConverter = 100;
        $payMongoValue = $userPayAmount * $payMongoConverter;

        $paymentSetting = app(PaymentSettingService::class);
        $createLink = $paymentSetting->create_paymongo_link($payMongoValue, $description, $remarks);
        if ($createLink['status'] == 200) {
            $checkoutUrl = @$createLink['body']['data']['attributes']['redirect']['checkout_url'];
            $failedurl = @$createLink['body']['data']['attributes']['redirect']['failed'];
            $successurl = @$createLink['body']['data']['attributes']['redirect']['success'];
            // $checkoutUrl = @$createLink['body']['attributes']['checkout_url'];

            if (!empty($checkoutUrl)) {
                $returns['checkout_url'] = @$checkoutUrl;
                $returns['reference_number'] = @$createLink['body']['data']['id'];
                $returns['status'] = 1;

            }
        } else {
            $returns['errors'] = $createLink['errors'];
        }

        return $returns;
    }

/**
 * @param integer $Id
 * @return array
 */
    public function edit(int $Id): array
    {
        $execution = $this->repository->edit($Id);
        $response = $this->api_service->api_returns($execution);

        return $response;
    }

/**
 * @param array $request
 * @return array
 */
    public function update(array $request): array
    {

        if (!is_integer($request['survey_id'])) {
            $SurveyService = app(SurveyService::class);
            $indexParams = ['filter' => json_encode(['survey_id' => ['filter' => $request['survey_id']]])];
            $surveySearch = $SurveyService->index($indexParams);

            // $request['survey_id'] = $surveySearch['id'];
            if (!empty($surveySearch['result'])) {
                $surveySearch = $surveySearch['result'][0];
                $request['survey_id'] = $surveySearch['id'];

                if (!empty($request['classes'])) {
                    $structure = [
                        'id' => $surveySearch['id'],
                    ];

                    switch ($request['classes']) {
                        case 'chip+chip-success':
                        case 'chip chip-success':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'finished',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);
                            break;
                        case 'chip+chip-warning':
                        case 'chip chip-warning':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'pending',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);

                            break;
                        case 'chip+chip-danger':
                        case 'chip chip-danger':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'rejected',
                            ];

                            $SurveyUpdate = $SurveyService->update($structure);
                            break;

                        case 'chip+chip-blue':
                        case 'chip chip-blue':
                        case 'chip+chip-primary':
                        case 'chip chip-primary':
                            $structure = [
                                'id' => $surveySearch['id'],
                                'status' => 'process',
                            ];
                            $SurveyUpdate = $SurveyService->update($structure);
                            break;

                    }
                }

            }
        }
        $request['id'] = $request['schedule_id_raw'];
        $execution = $this->repository->execute_update($request);

        $response = ['status' => $execution['status'], 'data_id' => $execution['data_id'], 'message' => ''];
        return $response;
    }

/**
 * @param integer $id
 * @return array
 */
    public function destroy(int $id): array
    {
        $existing_data = $this->edit($id);
        $execution = $this->repository->destroy($id);

        if ($execution['status'] === 1 && $existing_data) {
            $existing_data = $existing_data['result']->toArray() ?? $existing_data['result'];
            $audit_data = ['existing_data' => $existing_data];
            // $this->audit_service->store($audit_data);
        }

        $response = $this->api_service->api_returns($execution);

        return $response;
    }

/**
 * @return void
 */
    public function fillables(): void
    {
        $this->repository->fillables();
    }

    public function find_data($find)
    {
        $formatted = [];
        foreach ($find as $key => $value) {
            $formatted[key($value)] = ['filter' => current($value)];
        }

        $data = ['filters' => json_encode($formatted)];
        $execution = $this->repository->index($data);

        $execution['data'] = (count($execution['data']) == 1) ? $execution['data'][0] : $execution['data'];

        $response = $this->api_service->api_returns($execution);
        return $response;
    }

}
