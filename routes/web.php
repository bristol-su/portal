<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pages\ActivityController;
use App\Http\Controllers\Pages\PortalController;
use Illuminate\Support\Facades\Route;

// Laravel Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
//
//// Registration Routes...
Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
//
//// Email Verification Routes...
Route::get('email/verify', [\App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
//Route::middleware('link')->get('email/verify/authorize', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
//
// Password Reset Routes...
// Show the forgot password form
Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
//
//Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
//Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');
//
//// Landing Page Route
//Route::middleware('guest')->get('/', 'Pages\LandingController@index');
//Route::middleware('guest')->get('/login/provider/{provider}', 'Auth\SocialiteController@redirect');
//Route::middleware('guest')->get('/login/provider/{provider}/callback', 'Auth\SocialiteController@handleCallback');
//
Route::middleware(['auth', 'verified', 'portal'])->group(function () {
//    // Custom Authentication Routes
//    Route::get('/login/participant/{activity_slug}', 'Auth\LogIntoParticipantController@show')->name('login.participant');
//    Route::get('/login/admin/{activity_slug}', 'Auth\LogIntoAdminController@show')->name('login.admin');
//
//    Route::middleware(['nonmodule', 'can:view-management'])->namespace('Management')->group(function () {
//        // Settings Routes
//        Route::get('/management', 'ManagementController@index')->name('management');
//        Route::resource('activity', 'ActivityController')->only(['index', 'create', 'show']);
//        Route::resource('logic', 'LogicController')->only(['index', 'show', 'create']);
//        Route::resource('site-permission', 'SitePermissionController')->only(['index', 'show']);
//        Route::resource('connector', 'ConnectorController')->only(['index']);
//        Route::prefix('/activity/{activity}')->group(function () {
//            Route::resource('module-instance', 'ModuleInstanceController')->only(['show', 'create']);
//            Route::prefix('/module-instance/{module_instance}')->group(function () {
//                Route::resource('action', 'ActionController')->only(['create']);
//            });
//        });
//        Route::resource('action', 'ActionController')->only(['show'])->parameter('action', 'action_instance');
//        Route::get('settings', 'SettingsController@index');
//    });
//
//
//
//    // Portal Routes
//    Route::namespace('Pages')->group(function () {
//        Route::get('/control', 'ControlController@index')->name('control');
//
//        Route::middleware('nonmodule')->group(function () {
//            Route::get('/welcome', 'WelcomeController@welcome')->name('welcome');
    Route::get('/portal', [PortalController::class, 'portal'])->name('portal');
    Route::get('/a', [PortalController::class, 'administrator'])->name('administrator');
    Route::get('/p', [PortalController::class, 'participant'])->name('participant');
//            Route::get('/activity/{activity}/progress', 'ActivityProgressController@index');
//
//        });
//
    Route::middleware('activity')->group(function () {
        Route::middleware('administrator')->get('/a/{activity_slug}', [ActivityController::class, 'administrator'])->name('administrator.activity');
        Route::middleware('participant')->get('/p/{activity_slug}', [ActivityController::class, 'participant'])->name('participant.activity');
    });

//    });
//
});
