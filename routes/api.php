<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CoachController;
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

Route::get('/coach/by-user-id/{user_id}', [CoachController::class, 'getCoachByUserId']);
Route::post('insert_payment', [App\Http\Controllers\API\transactionController::class, 'insert_payment']);


Route::post('login', [App\Http\Controllers\API\UserController::class, 'login'])->name('login');
Route::post('signup', [App\Http\Controllers\API\UserController::class, 'signup'])->name('signup');
Route::post('update_user_info', [App\Http\Controllers\API\UserController::class, 'update_user_info'])->name('update_user_info');
Route::post('update_user_profile', [App\Http\Controllers\API\UserController::class, 'update_user_profile'])->name('update_user_profile');
Route::post('weekly_checkin', [App\Http\Controllers\API\UserController::class, 'weekly_checkin'])->name('weekly_checkin');
Route::post('update_weekly_checkin', [App\Http\Controllers\API\UserController::class, 'update_weekly_checkin'])->name('update_weekly_checkin');
Route::post('weekly_checkin_history', [App\Http\Controllers\API\UserController::class, 'weekly_checkin_history'])->name('weekly_checkin_history');
Route::post('monthly_checkin', [App\Http\Controllers\API\UserController::class, 'monthly_checkin'])->name('monthly_checkin');
Route::post('monthly_checkin_history', [App\Http\Controllers\API\UserController::class, 'monthly_checkin_history'])->name('monthly_checkin_history');
Route::post('update_monthly_checkin', [App\Http\Controllers\API\UserController::class, 'update_monthly_checkin'])->name('update_monthly_checkin');
Route::post('update_cover_pic', [App\Http\Controllers\API\UserController::class, 'update_cover_pic'])->name('update_cover_pic');
Route::post('body_stats', [App\Http\Controllers\API\UserController::class, 'body_stats'])->name('body_stats');
Route::get('videos', [App\Http\Controllers\API\UserController::class, 'videos'])->name('videos');
Route::post('chat', [App\Http\Controllers\API\UserController::class, 'chat'])->name('chat');
Route::post('chat_list', [App\Http\Controllers\API\UserController::class, 'chat_list'])->name('chat_list');
Route::get('plans', [App\Http\Controllers\API\UserController::class, 'plans'])->name('plans');
Route::post('workout', [App\Http\Controllers\API\UserController::class, 'workout'])->name('workout');
Route::get('meal_plan_question_one', [App\Http\Controllers\API\UserController::class, 'meal_plan_question_one'])->name('meal_plan_question_one');
Route::post('meal_plan_answer_one', [App\Http\Controllers\API\UserController::class, 'meal_plan_answer_one'])->name('meal_plan_answer_one');
Route::get('questions', [App\Http\Controllers\API\UserController::class, 'questions'])->name('questions');
Route::post('submit_question', [App\Http\Controllers\API\UserController::class, 'submit_question'])->name('submit_question');
Route::post('submit_question_ios', [App\Http\Controllers\API\UserController::class, 'submit_question_ios'])->name('submit_question_ios');





	Route::post('forgot_password', [App\Http\Controllers\API\UserController::class, 'forgot_password'])->name('forgot_password');
	Route::post('verify_otp', [App\Http\Controllers\API\UserController::class, 'verify_otp'])->name('verify_otp');
	Route::post('reset_password', [App\Http\Controllers\API\UserController::class, 'reset_password'])->name('reset_password');
	Route::post('history', [App\Http\Controllers\API\UserController::class, 'history'])->name('history');

	Route::post('change_password',[App\Http\Controllers\API\UserController::class,'change_password'])->name('change_password');

	Route::post('cancel-plan',[App\Http\Controllers\API\UserController::class,'cancel_plan'])->name('cancel-plan');

    Route::post('meals',[App\Http\Controllers\API\UserController::class,'meals'])->name('meals');

    Route::post('meals-ios',[App\Http\Controllers\API\UserController::class,'meals_ios'])->name('meals-ios');

	Route::post('request-for-meal',[App\Http\Controllers\API\UserController::class,'meal_request'])->name('request-for-meal');

	Route::post('notification',[App\Http\Controllers\API\UserController::class,'notification'])->name('notification');

	Route::post('honey-option',[App\Http\Controllers\API\UserController::class,'honey_option'])->name('honey-option');

	Route::post('honey-option',[App\Http\Controllers\API\UserController::class,'honey_option'])->name('honey-option');

	Route::post('body_stats/ios', [App\Http\Controllers\API\UserController::class, 'body_stats_ios'])->name('body_stats_ios');

	Route::post('workout/ios', [App\Http\Controllers\API\UserController::class, 'workout_ios'])->name('workout_ios');

	Route::post('current-shot',[App\Http\Controllers\API\UserController::class,'current_shot'])->name('current-shot');

	Route::post('old-shot',[App\Http\Controllers\API\UserController::class,'old_shot'])->name('old-shot');
  
	Route::post('payment-status',[App\Http\Controllers\API\UserController::class,'payment_status']);

	Route::post('delete-account',[App\Http\Controllers\API\UserController::class,'delete_account']);
	
	Route::post('/update-fcm-token',[App\Http\Controllers\API\UserController::class,'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/**
 * social login
 */

 /**
  * google login
  */

  Route::post('Glogin', [App\Http\Controllers\API\SocialController::class, 'Glogin'])->name('Glogin');

  Route::post('Flogin',[App\Http\Controllers\API\SocialController::class,'Flogin'])->name('Flogin');

  Route::post('ios-login-dev',[App\Http\Controllers\API\SocialController::class,'ios_login'])->name('Ilogin');
  Route::post('ios-login',[App\Http\Controllers\API\SocialController::class,'ios_login_dev'])->name('Ilogin');

  
  
  Route::get('clear_cache', function () {

	\Artisan::call('cache:clear');

	dd("Cache is cleared");

});


