<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;
use App\Models\Application;
use Illuminate\Support\Facades\Route;

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

//signup
Route::post('app/signup', [AdminController::class, 'signup']);
//login
Route::post('app/login', [AdminController::class, 'login']);
//upload image
Route::post('app/upload', [AdminController::class, 'upload']);
//CHANGE PASSWORD
Route::post('app/change_password', [AdminController::class, 'changePassword']);
//USER
Route::get('app/get_users', [AdminController::class, 'getUser' ]);
Route::post('app/delete_user', [AdminController::class, 'deleteUser' ]);
Route::post('app/get_user_with_license', [AdminController::class, 'getUserWithLicense' ]);
Route::post('app/update_user', [AdminController::class, 'updateUser']);

//FEEDBACKS
Route::get('app/get_feedbacks', [FeedbackController::class, 'index']);
Route::post('app/send_feedback', [FeedbackController::class, 'create']);
Route::post('app/delete_feedback', [FeedbackController::class, 'delete' ]);

//APPLICATION
Route::post('app/apply', [ApplicationController::class, 'create']);
Route::get('app/get_applications', [ApplicationController::class, 'showApplications']);
Route::get('app/get_processed_applications', [ApplicationController::class, 'showProcessedApplications']);
Route::post('app/disapprove_application', [ApplicationController::class, 'disapprove']);
Route::post('app/approve_application', [ApplicationController::class, 'approve']);
Route::post('app/send_email', [MailController::class, 'callEmail']);

//LICENSE
Route::get('app/get_licenses', [LicenseController::class, 'showLicenses']);
//RENEWAL
Route::post('app/renew', [LicenseController::class, 'update']);
//PAYMENT GATEWAY
Route::get('/paypal', function(){
    return view('payment.paypal');
});
Route::get('/renewal_paypal', function(){
    return view('payment.renewal_paypal');
});
Route::post('/application_payment', [PaymentController::class, 'applicationPayment']);
Route::post('/renewal_payment', [PaymentController::class, 'renewalPayment']);
// ----------------------------------------------------------------------------------------
Route::get('/404', function(){
    return view('errors.404');
});
Route::get('logout', [AdminController::class, 'logout']);
Route::get('/', [AdminController::class, 'index']);
Route::any('{slug}', [AdminController::class, 'index']);