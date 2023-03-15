<?php

use App\BearerTokenService;
use App\Http\Middleware\RequireBearerToken;
use App\Mail\TestMail;
use App\Imports\OutboxImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group([
//   'prefix' => 'auth'
// ], function () {
//   Route::post('login', 'AuthController@login');

//   Route::group([
//     'middleware' => 'auth:api'
//   ], function() {
//       Route::get('logout', 'AuthController@logout');
//       Route::get('user', 'AuthController@user');
//   });
// });


Route::get('get_contents', 'ContentManagementController@api_index');
Route::POST('create_payment_link', 'PaymentController@create_payment_link');
Route::POST('newsletter_unsubscribe', 'NewsletterSubscriptionController@newsletter_unsubscribe');
Route::POST('newsletter_subscribe', 'NewsletterSubscriptionController@newsletter_subscribe');
Route::get('test_prov', 'TestController@testerfunction');

Route::POST('request_survey', 'SurveyController@create_survey');
Route::POST('track_survey', 'SurveyController@track_survey');
Route::GET('scheduled_dates', 'SurveyController@scheduled_dates');

