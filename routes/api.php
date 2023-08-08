<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TrustedContactController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('check-email',  [AuthController::class, 'checkEmail']);
    Route::post('register',  [AuthController::class, 'register']);

    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('verify', [VerificationController::class, 'verify'])->middleware(['throttle:6,1']);
    Route::post('google/login',  [GoogleLoginController::class, 'handleTokenCallback']);
    Route::post('apple/login', [AppleLoginController::class, 'handleAppleCallback']);
});

Route::group([
    'middleware'=> 'jwt.auth'
], function ($router) {
    Route::resource('trusted-contacts', TrustedContactController::class);

    Route::get('plans', [PlanController::class, 'index']);
    Route::get('plans/{plan}', [PlanController::class, 'show']);
    Route::post('subscription', [PlanController::class, 'subscription']);

    Route::get('/user/settings', [SettingController::class, 'index']);
    Route::patch('/user/settings', [SettingController::class, 'update']);

    Route::get('/get-user', [UserController::class, 'index']);

});

// TODO for sliders will be only list
Route::get('sliders', [SliderController::class, 'index']);
Route::get('sliders/{slider}', [SliderController::class, 'show']);
Route::post('sliders', [SliderController::class, 'store']);
Route::put('sliders/{slider}', [SliderController::class, 'update']);
Route::delete('sliders/{slider}', [SliderController::class, 'destroy']);

