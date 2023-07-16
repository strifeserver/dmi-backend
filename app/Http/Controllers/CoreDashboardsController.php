<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ScheduleService;
use App\Services\SurveyService;
use App\Services\WorkerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Survey;

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
                        if($value['status'] == 1){
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
                ]);
                break;
        }

    }

    public function fetchAnalytics($data)
    {
        $surveyService = app(SurveyService::class);
        $from = date('Y-m-d', strtotime('-7 days'));
        $to = date('Y-m-d');


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

    public function schedules()
    {

        // $scheduleParams = [];
        // echo '<pre>';
        $ScheduleService = app(ScheduleService::class);
        $schedules = $ScheduleService->index([]);

        // $results = $schedules['result'];

        $schedules["result"] = array_map(function ($item) {
            // $item["start_date"] = $item["date"];
            if (empty($item["end_date"])) {
                $item["end_date"] = $item["start_date"];
            }
            if(!empty($item['survey_id'])){
                $fetchSurveyID = Survey::where('id','=',$item['survey_id'])->first();
                if(!empty($fetchSurveyID)){
                    $item['survey_code'] = $fetchSurveyID['survey_id'];
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
        print_r($execution);
        exit;
        // return $execution;

    }
    public function scheduleUpdate(request $request)
    {

        $ScheduleService = app(ScheduleService::class);

        $execution = $ScheduleService->update($request->all());
        // return $execution;

    }
}
