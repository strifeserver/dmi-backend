<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ScheduleService;
use App\Services\SurveyService;
use App\Services\WorkerService;
use App\Survey;
use App\transaction;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class CoreDashboardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routen = Route::getFacadeRoot()->current()->uri();

        switch ($routen) {
            case 'dashboard':
                $pageConfigs = [
                    'pageHeader' => false,
                ];

                return view('/pages/dashboard-ecommerce', [
                    'pageConfigs' => $pageConfigs,
                ]);
                break;

            default:
                $surveyService = app(SurveyService::class);
                $workerService = app(WorkerService::class);

                $InitialFilter = 0;
                $workerCount = 0;
                $analyticsFilterDates = $surveyService->analyticsFilterDates($InitialFilter);
                $fetchAnalyticsParam = ['template_filters' => ['created_at' => $analyticsFilterDates]];
                $fetchAnalytics = $this->fetchAnalytics($fetchAnalyticsParam);

                $survey_ids = array(); // create an empty array to store the survey_ids

                $getSurveys = $surveyService->index([]);
                $getWorkers = $workerService->index([]);
                if (!empty($getWorkers['result'])) {
                    foreach ($getWorkers['result'] as $key => $value) {
                        if ($value['status'] == 1) {
                            $workerCount++;
                        }

                    }
                    // $workerCount = count($getWorkers['result']);
                }

                if (!empty($getSurveys['result'])) {

                    foreach ($getSurveys['result'] as $item) {
                        $survey_ids[] = $item["survey_id"]; // extract the survey_id value and add it to the array
                    }

                }
                $authid = auth()->id();
                $getUser = User::where('id', '=', $authid)->first();
                $access_level = $getUser->access_level;

                return view('/pages/dashboard-analytics', [
                    'workerCount' => $workerCount,
                    'survey_ids' => $survey_ids,
                    'finishedSurveyCount' => $fetchAnalytics['finishedSurveyCount'],
                    'pendingSurveyCount' => $fetchAnalytics['pendingSurveyCount'],
                    'rejectedSurveyCount' => $fetchAnalytics['rejectedSurveyCount'],
                    'totalSurveyCount' => $fetchAnalytics['totalSurveyCount'],
                    'finishedSurveyPercentage' => $fetchAnalytics['finishedSurveyPercentage'],
                    'pendingSurveyPercentage' => $fetchAnalytics['pendingSurveyPercentage'],
                    'rejectedSurveyPercentage' => $fetchAnalytics['rejectedSurveyPercentage'],
                    'access_level' => $access_level,
                ]);
                break;
        }

    }

    public function fetchAnalytics($data)
    {
        $surveyService = app(SurveyService::class);
        $from = date('Y-m-d', strtotime('-7 days'));
        $to = date('Y-m-d');

        if (!empty($data['template_filters']['created_at']['to'])) {
            $date = new DateTime("2023-09-27");
            $date->add(new DateInterval('P2D'));

            $data['template_filters']['created_at']['to'] = $date->format('Y-m-d');
        }

        $pendingParams = [['status' => 'pending'], $data['template_filters']];
        $pendingParams = [
            'filter' => [
                'status' => ['filter' => 'pending'],
                'created_at' => $data['template_filters']['created_at'],
            ],

        ];
        $finishedParams = [['status' => 'finished'], $data['template_filters']];
        $finishedParams = [
            'filter' => [
                'status' => ['filter' => 'finished'],
                'created_at' => $data['template_filters']['created_at'],
            ],

        ];
        $rejectedParams = [['status' => 'rejected'], $data['template_filters']];
        $rejectedParams = [
            'filter' => [
                'status' => ['filter' => 'rejected'],
                'created_at' => $data['template_filters']['created_at'],
            ],

        ];

        $pendingParams['filter'] = json_encode($pendingParams['filter']);
        $finishedParams['filter'] = json_encode($finishedParams['filter']);
        $rejectedParams['filter'] = json_encode($rejectedParams['filter']);

        $pendingSurveys = $surveyService->index($pendingParams);

        $finishedSurveys = $surveyService->index($finishedParams);

        $finishedSurveyCount = count($finishedSurveys['result'] ?? []);

        $pendingSurveyCount = count($pendingSurveys['result'] ?? []);

        $rejectedSurveys = $surveyService->index($rejectedParams);

        $rejectedSurveyCount = count($rejectedSurveys['result'] ?? []);

        $totalSurveyCount = $finishedSurveyCount + $pendingSurveyCount + $rejectedSurveyCount;
        try {
            $finishedSurveyPercentage = round(($finishedSurveyCount / $totalSurveyCount) * 100, 2);
        } catch (\Throwable $th) {
            $finishedSurveyPercentage = 0;
        }
        try {
            $pendingSurveyPercentage = round(($pendingSurveyCount / $totalSurveyCount) * 100, 2);
        } catch (\Throwable $th) {
            $pendingSurveyPercentage = 0;
        }
        try {
            $rejectedSurveyPercentage = round(($rejectedSurveyCount / $totalSurveyCount) * 100, 2);
        } catch (\Throwable $th) {
            $rejectedSurveyPercentage = 0;
        }

        return [
            'finishedSurveyCount' => $finishedSurveyCount,
            'pendingSurveyCount' => $pendingSurveyCount,
            'rejectedSurveyCount' => $rejectedSurveyCount,
            'totalSurveyCount' => $totalSurveyCount,
            'finishedSurveyPercentage' => $finishedSurveyPercentage,
            'pendingSurveyPercentage' => $pendingSurveyPercentage,
            'rejectedSurveyPercentage' => $rejectedSurveyPercentage,
        ];
    }

    public function filterAnalytics(request $request)
    {
        $surveyService = app(SurveyService::class);

        $status = request('status');
        // $InitialFilter = 0;
        $analyticsFilterDates = $surveyService->analyticsFilterDates($status);
        $fetchAnalyticsParam = ['template_filters' => ['created_at' => $analyticsFilterDates]];
        $fetchAnalytics = $this->fetchAnalytics($fetchAnalyticsParam);

        return [
            'finishedSurveyCount' => $fetchAnalytics['finishedSurveyCount'],
            'pendingSurveyCount' => $fetchAnalytics['pendingSurveyCount'],
            'rejectedSurveyCount' => $fetchAnalytics['rejectedSurveyCount'],
            'totalSurveyCount' => $fetchAnalytics['totalSurveyCount'],
            'finishedSurveyPercentage' => $fetchAnalytics['finishedSurveyPercentage'],
            'pendingSurveyPercentage' => $fetchAnalytics['pendingSurveyPercentage'],
            'rejectedSurveyPercentage' => $fetchAnalytics['rejectedSurveyPercentage'],
        ];
    }

    public function hashValidator()
    {
        $returns = [
            'status' => 1,
            'code' => 200,
            'message' => '',
        ];
        $encodedString = request('hash');
        $decodedString = base64_decode($encodedString);
        $token = Session::token();
        $comparison = $token . ' == ' . $decodedString;
        $referrer = $_SERVER['HTTP_REFERER'] ?? null;

        $allowedUrl = ['http://dmiph.online/', 'http://127.0.0.1:8000/'];

        if (!Session::token() === $token) {
            $returns['message'] = 'CSRF Token mismatch';
            $returns['code'] = 403;
            // Token mismatch, handle it as needed (e.g., return an error response)
        }

        if (!in_array($referrer, $allowedUrl)) {
            // Token mismatch, handle it as needed (e.g., return an error response)
            $returns['code'] = 403;
            $returns['message'] = 'URL Not allowed';
        }

        $returns['referrer'] = $referrer;
        return $returns;
    }

    public function schedules()
    {
        $ScheduleService = app(ScheduleService::class);
        $schedules = $ScheduleService->index([]);

        $hashvalidator = $this->hashValidator();
        if ($hashvalidator['code'] != 200) {
            return response()->json(['message' => $hashvalidator['message']], $hashvalidator['code']);
        }

        $schedules["result"] = array_map(function ($item) {
            if (empty($item["end_date"])) {
                $item["end_date"] = $item["start_date"];
            }
            if (!empty($item['survey_id'])) {
                $fetchSurveyID = Survey::where('id', '=', $item['survey_id'])->first();
                if (!empty($fetchSurveyID)) {
                    $item['survey_code'] = $fetchSurveyID['survey_id'];
                    $item['survey_customer_name'] = $fetchSurveyID['name'];
                    $item['survey_customer_email'] = $fetchSurveyID['email_address'];

                }
                $transaction = transaction::where('tagged_schedule_id', '=', $item['id'])->first();
                if (!empty($transaction)) {
                    $item['transaction_id'] = $transaction['id'];
                    $item['transaction_amount'] = $transaction['requested_amount'];
                    $item['transaction_status'] = $transaction['status'];
                }

            }
            unset($item["date"]);
            return $item;
        }, $schedules["result"]);


        return $schedules;
    }

    public function scheduleInsert(request $request)
    {
        $ScheduleService = app(ScheduleService::class);
        $execution = $ScheduleService->store($request->all());
        return $execution;

    }
    public function scheduleUpdate(request $request)
    {

        $ScheduleService = app(ScheduleService::class);

        $execution = $ScheduleService->update($request->all());
        // return $execution;

    }

    public function scheduleDelete(request $request)
    {

        $ScheduleService = app(ScheduleService::class);
        $keys = array_keys($request->all());
        $id = $keys[0];
        $execution = $ScheduleService->destroy($id);

    }

    public function dpa()
    {

        return view('auth.dta');
    }
}
