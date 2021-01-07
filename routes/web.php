<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pages\ActivityController;
use App\Http\Controllers\Pages\PortalController;
use Illuminate\Support\Facades\Route;

//
//// Landing Page Route
Route::middleware('portal-guest')->get('/', [\App\Http\Controllers\Pages\LandingController::class, 'index']);
//Route::middleware('guest')->get('/login/provider/{provider}', 'Auth\SocialiteController@redirect');
//Route::middleware('guest')->get('/login/provider/{provider}/callback', 'Auth\SocialiteController@handleCallback');
//

Route::get('/theme/demo', function() {
   return view('theme-demo')->withErrors([
       'my-select-2' => ['This is the first error', 'And this is the second!'],
       'date-of-birth' => ['Your date of birth must be in the past']
   ]);
});


Route::middleware(['portal-auth'])->group(function () {
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
        Route::redirect('/welcome', '/portal')->name('welcome');
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

Route::middleware('portal-auth')->name('test-1')->get('/test-1', function() {
    return response('You are logged in');
});
Route::middleware(['portal-auth', 'portal-verified'])->get('/test-2', function() {
    return response('You are logged in and email is verified');
})->name('test-2');
Route::middleware(['portal-auth', 'portal-verified', 'portal-confirmed'])->get('/test-3', function() {
    return response('You are logged in, verified and confirmed');
})->name('test-3');
Route::middleware(['portal-guest'])->get('/test-4', function() {
    return response('You are a guest');
})->name('test-4');
Route::middleware(['portal-not-verified'])->get('/test-5', function() {
    return response('You are not verified');
})->name('test-5');
Route::get('/test-6', function() {
    return response('You are nothing');
})->name('test-6');
Route::get('/logout-test', function() {
    return '
        <html><body><form action="' . route('logout') . '" method="post">' . csrf_field() . '<button type="submit">Logout</button></form></body></html>
    ';
});
