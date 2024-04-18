<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\API\SocialController;
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
Route::get('stripeResponse', [paymentController::class, 'response'])->name('stripeResponse');
// Route::view('payment-form','admin.payment.form');
Route::get('payment-form/userId/{userId}/planId/{planId}', [paymentController::class, 'payment_form'])->name('payment-form');

Route::get('apple-callback', [SocialController::class, 'apple_callback'])->name('apple-callback');

Route::get('/', function () {
    return view('welcome');
});

//Route::view('privacyPolicy', 'privacyPolicy');
//Route::view('terms-and-condition', 'terms_and_condition');

Route::get('by-pass-account', [StatusController::class, 'index'])->name('by-pass');
Route::post('/update-payment-status', [StatusController::class, 'updatePaymentStatus'])->name('update.payment.status');


Route::post('/mark-all-notifications', [StatusController::class, 'markAllAsRead'])->name('mark-all-notifications');

Route::get('admin-login', [App\Http\Controllers\AdminController::class, 'index'])->name('admin-login');
Route::get('privacy-policy', [App\Http\Controllers\AdminController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('terms-and-condition', [App\Http\Controllers\AdminController::class, 'terms_and_condition'])->name('terms-and-condition');
Route::post('admin-login-post', [App\Http\Controllers\AdminController::class, 'login_post'])->name('admin-login-post');

Route::get('plan-payment/{planId}/{userId}', [App\Http\Controllers\AdminController::class, 'plan_payment'])->name('plan-payment');
Route::post('userPayment', [App\Http\Controllers\AdminController::class, 'userPayment'])->name('userPayment');
Route::get('paymentSuccessfull', [App\Http\Controllers\AdminController::class, 'paymentSuccessfull'])->name('paymentSuccessfull');

// Route::group(['middleware'=>['adminBasicAuth']],function(){

Route::get('admin-dashboard', [App\Http\Controllers\AdminController::class, 'admin_dashboard'])->name('admin-dashboard');
Route::get('professional', [App\Http\Controllers\AdminController::class, 'professional'])->name('professional');
Route::get('estimate', [App\Http\Controllers\AdminController::class, 'estimate'])->name('estimate');
Route::get('add-estimate', [App\Http\Controllers\AdminController::class, 'add_estimate'])->name('add-estimate');


Route::get('add-professional', [App\Http\Controllers\AdminController::class, 'add_professional'])->name('add-professional');
Route::post('post-add-professional', [App\Http\Controllers\AdminController::class, 'post_add_professional'])->name('post-add-professional');
Route::get('delete-professional/{id}', [App\Http\Controllers\AdminController::class, 'delete_professional'])->name('delete-professional');
Route::get('view-professional/{id}', [App\Http\Controllers\AdminController::class, 'view_professional'])->name('view-professional');
Route::post('change-status', [App\Http\Controllers\AdminController::class, 'change_status'])->name('change-status');
Route::post('proff-update', [App\Http\Controllers\AdminController::class, 'proff_update'])->name('proff-update');
Route::get('delete-skill/{id}/{userId}', [App\Http\Controllers\AdminController::class, 'delete_skill'])->name('delete-skill');
Route::post('add-skill', [App\Http\Controllers\AdminController::class, 'add_skill'])->name('add-skill');
Route::post('add-more-images', [App\Http\Controllers\AdminController::class, 'add_more_images'])->name('add-more-images');
Route::get('delete-more-images/{id}', [App\Http\Controllers\AdminController::class, 'delete_more_images'])->name('delete-more-images');
Route::post('update-proffessional-status', [App\Http\Controllers\AdminController::class, 'update_proffessional_status'])->name('update-proffessional-status');

Route::get('videos', [App\Http\Controllers\AdminController::class, 'videos'])->name('videos');
Route::get('add-videos', [App\Http\Controllers\AdminController::class, 'add_videos'])->name('add-videos');
Route::post('post-add-videos', [App\Http\Controllers\AdminController::class, 'post_add_videos'])->name('post-add-videos');
Route::get('delete-video/{id}',[AdminController::class,'delete_video']);

Route::get('add-coach', [App\Http\Controllers\CoachController::class, 'add_coach'])->name('add-coach');
Route::post('post-add-coach', [App\Http\Controllers\CoachController::class, 'store'])->name('store');
Route::get('view-coach', [App\Http\Controllers\CoachController::class, 'index'])->name('coach.index');
Route::get('/coaches/{id}/edit',[App\Http\Controllers\CoachController::class, 'edit'])->name('coaches.edit');
Route::put('/coaches/{id}', [App\Http\Controllers\CoachController::class, 'update'])->name('coaches.update');
Route::delete('/coaches/{id}',[App\Http\Controllers\CoachController::class, 'destroy'])->name('coaches.destroy');


Route::get('assign-coach/{id} ', [App\Http\Controllers\CoachController::class, 'assign'])->name('assign-coach');
Route::put('/users/{id}/update-coach', [App\Http\Controllers\CoachController::class, 'updateCoach'])->name('users.update-coach');


Route::get('ExportProfessional', [App\Http\Controllers\AdminController::class, 'ExportProfessional'])->name('ExportProfessional');
Route::get('notifications', [AdminController::class,'notifications']);



// Plans Route

Route::get('/plans',[AdminController::class,'plans']);

Route::get('/add-plans',[AdminController::class,'add_plans']);

Route::post('/post-add-plans',[AdminController::class,'post_add_plans']);

Route::get('/edit_plan/{id}',[AdminController::class,'edit_plan']);

Route::put('/update_plan',[AdminController::class,'update_plan']);

Route::get('/delete_plan/{id}',[AdminController::class,'delete_plan']);

// Checkins Route

Route::get('/weekly_check',[App\Http\Controllers\AdminController::class,'weekly_check']);

Route::get('/monthly_check',[App\Http\Controllers\AdminController::class,'monthly_check']);

// Workout Route

Route::get('/workout',[AdminController::class,'workout'])->name('admin-workout');
Route::get('/add-workout',[AdminController::class,'add_workout'])->name('add_workout');
Route::get('/get-exercises/{id}',[AdminController::class,'get_exercises']);
Route::get('add-exercise',[AdminController::class,'add_exercise']);
Route::get('show-exercises',[AdminController::class,'show_exercises']);
Route::get('delete-added-exercise/{id}',[AdminController::class,'delete_added_exercise']);
Route::post('post-update-exercise',[AdminController::class,'post_update_exercise']);
Route::post('post-add-exercise',[AdminController::class,'post_add_exercise']);
Route::post('post-add-workout',[AdminController::class,'post_add_workout']);
Route::get('/user-workout/{id}',[AdminController::class,'user_workout'])->name('user-workout');
Route::get('/delete-workout/{id}',[AdminController::class,'delete_workout']);
Route::get('/delete-exercise/{id}',[AdminController::class,'delete_exercise'])->name('delete_exercise');

Route::get('/meals',[AdminController::class,'meals']);
Route::get('add-meals',[AdminController::class,'add_meals']);
Route::get('user-questions',[AdminController::class,'user_questions'])->name('user-questions');
Route::post('meal-quantity',[AdminController::class,'meal_quantity']);
Route::post('post-add-meals',[AdminController::class,'post_add_meals']);

Route::post('post-update-meals',[AdminController::class,'post_update_meals']);
Route::get('delete-meal/{id}',[AdminController::class,'delete_meal']);


Route::get('subscription',[AdminController::class,'subscription']);
Route::get('show-history/{user_id}',[AdminController::class,'show_history']);

Route::get('request-for-meal',[AdminController::class,'request_for_meal']);

Route::get('show-user-weekly/{id}',[AdminController::class,'show_user_weekly']);
Route::get('show-user-monthly/{id}',[AdminController::class,'show_user_monthly']);

Route::get('chat/{id}',[AdminController::class,'chat']);
Route::post('post-chat/{id}',[AdminController::class,'get_chat']);


Route::get('transactions',[paymentController::class,'transactions'])->name('transactions');
Route::get('transaction-details/txnId/{txnId}',[paymentController::class,'transactions_details'])->name('transaction-details');


// });

Route::get('sendbasicemail', [App\Http\Controllers\AdminController::class, 'basic_email'])->name('sendbasicemail');
Route::get('sendhtmlemail', [App\Http\Controllers\AdminController::class, 'html_email'])->name('sendhtmlemail');
Route::get('sendattachmentemail', [App\Http\Controllers\AdminController::class, 'attachment_email'])->name('sendattachmentemail');


Route::get('logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');


/**
 * social login
 */

Route::get('/Glogin/redirect', function () {
    return Socialite::driver('google')->stateless()->redirect();
});


Route::get('auth-facebook',[App\Http\Controllers\API\SocialController::class,'facebook_redirect']);

Route::get('/facebook/call-back', [App\Http\Controllers\API\SocialController::class, 'facebook_callback'])->name('facebook-callback');


/**
 * payment gateway
 */
Route::get('checkout-form/userId/{userId}/planId/{planId}', [paymentController::class, 'index'])->name('checkout-form');

Route::post('pay', [paymentController::class, 'post_payment'])->name('pay');

Route::post('webhook', [paymentController::class, 'webhook'])->name('webhook');
