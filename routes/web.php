<?php
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Pagination\PaginationHelper;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route url
Auth::routes();

Route::get('/passwordExpiration','PasswordController@showPasswordExpirationForm');
Route::get('/passwordReset','PasswordController@showPasswordReset');
Route::get('/passwordOTP','PasswordController@showPasswordOtpForm');
Route::get('/password2FA','PasswordController@showPassword2FAForm');
Route::get('/ResendOTP','PasswordController@ResendOTP');
Route::get('logout/{forced?}', 'Auth\LoginController@logout');
Route::post('/passwordExpiration','PasswordController@postPasswordExpiration');
Route::post('/passwordReset','PasswordController@postPasswordReset');
Route::post('/passwordOTP','PasswordController@postPasswordOTP');
Route::post('/password2FA','PasswordController@postValidateToken');
// FORGOT PASSWORD ROUTE
Route::get('/forgot-password', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('/forgot-password', 'Auth\ForgotPasswordController@email');

Route::group(['middleware'=>['customChecker']],function(){

// CONTROLLERS WHERE IT REQUIRES USER LOGGED IN
	Route::get('/json/js-vars', function() {
		$timeout = DB::table('core_settings')
			->where('setting_name', 'idle_timeout')
			->first();

		return response()->json([
			'idle_timeout' => $timeout->setting_value
		]);
	});


	Route::post('change-password', 'UsersController@update_my_account');
	Route::get('/users/account_settings', 'UsersController@account_settings');
	Route::post('/users/update_my_account', 'UsersController@update_my_account');

	Route::get('/', 'CoreDashboardsController@index');
	Route::get('/schedules', 'CoreDashboardsController@schedules');
});

Route::get('/session-check', function() {
	return response()->json(['authorized' => Auth::check()]);
});

Route::post('/users/make_temp', 'UsersController@make_temp');

if(Schema::hasTable('core_navigations')){
	$navs = DB::table('core_navigations')
		->select('id','nav_name','nav_mode','nav_controller')
		->get();
	PaginationHelper::routes($navs->toArray());
	foreach ($navs as $key => $value) {
	
		if(!$value->nav_controller)
			continue;
			



		if(!$value->nav_controller == 'SMSSimulator')
		continue;

					
		// if($value->nav_mode == 'viber_outbox'){
	
			
		// }

		Route::resource($value->nav_mode, ''.$value->nav_controller.'Controller')
		->middleware('authorize_module_access:' . $value->id);

		// +------------------
		// 09/23/20 feat/rev2:
		// Allow additional routes for pagination
		//
		$class = $value->nav_controller . 'Controller';
		$fullPath =  '\App\Http\Controllers\\' . $class;

		if(method_exists($fullPath, 'paginate')) {
			Route::get("paginate/{$value->nav_mode}", "{$class}@paginate");
		}

		if(method_exists($fullPath, 'tableInfo')) {
			Route::get("tableinfo/{$value->nav_mode}", "{$class}@tableInfo");
		}
	}
}

if(Schema::hasTable('core_filter_links')){
	$navs = DB::table('core_filter_links')
		->select('id','nav_name','nav_mode','nav_controller')
		->get();
		foreach ($navs as $key => $value) {
			if(!$value->nav_controller)
			continue;
			Route::post($value->nav_mode, ''.$value->nav_controller.'Controller@filter')
			->middleware('authorize_module_access:' . $value->id);
	}
}

Route::get('/auth-reset-password', 'AuthenticationController@reset_password');
// CONTROLLERS WHERE IT DOESNT REQUIRE LOG IN




Route::put('/submit_account_settings', 'AccountSettingsController@index')->name('submit_account_settings');








Route::get('/auth-reset-password', 'AuthenticationController@reset_password');
// CONTROLLERS WHERE IT DOESNT REQUIRE LOG IN

Route::get('/filter_analytics', 'CoreDashboardsController@filterAnalytics');
Route::post('/schedule_insert', 'CoreDashboardsController@scheduleInsert');
// Route::get('/filter_analytics', 'CoreDashboardsController@filterAnalytics');