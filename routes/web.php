<?php


use App\Http\Controllers\Pages\ActivityController;
use App\Http\Controllers\Pages\PortalController;
use Illuminate\Support\Facades\Route;

// Landing Page Route
Route::middleware('portal-guest')->get('/', [\App\Http\Controllers\Pages\LandingController::class, 'index']);

Route::middleware(['portal-auth'])->group(function () {


    // Custom Authentication Routes
    Route::get('/login/participant/{activity_slug}', [\App\Http\Controllers\Auth\LogIntoParticipantController::class, 'show'])->name('login.participant');
    Route::get('/login/admin/{activity_slug}', [\App\Http\Controllers\Auth\LogIntoAdminController::class, 'show'])->name('login.admin');

    Route::middleware(['nonmodule', 'can:view-management'])->group(function () {
        // Settings Routes
        Route::get('/management', [\App\Http\Controllers\Management\ManagementController::class, 'index'])->name('management');
        Route::resource('activity', ActivityController::class)->only(['index', 'create', 'show']);
        Route::resource('logic', \App\Http\Controllers\Management\LogicController::class)->only(['index', 'show', 'create']);
        Route::resource('site-permission', \App\Http\Controllers\Management\SitePermissionController::class)->only(['index', 'show']);
        Route::resource('connector', \App\Http\Controllers\Management\ConnectorController::class)->only(['index']);
        Route::prefix('/activity/{activity}')->group(function () {
            Route::resource('module-instance', \App\Http\Controllers\Management\ModuleInstanceController::class)->only(['show', 'create']);
            Route::prefix('/module-instance/{module_instance}')->group(function () {
                Route::resource('action', \App\Http\Controllers\Management\ActionController::class)->only(['create']);
            });
        });
        Route::resource('action', \App\Http\Controllers\Management\ActionController::class)->only(['show'])->parameter('action', 'action_instance');
        Route::get('settings', [\App\Http\Controllers\Management\SettingsController::class, 'index']);
    });


    // Portal Routes
    Route::get('/control', [\App\Http\Controllers\Pages\ControlController::class, 'index'])->name('control');

    Route::middleware('nonmodule')->group(function () {
        Route::get('/portal', [PortalController::class, 'portal'])->name('portal');
        Route::get('/a', [PortalController::class, 'administrator'])->name('administrator');
        Route::get('/p', [PortalController::class, 'participant'])->name('participant');
        Route::get('/activity/{activity}/progress', [\App\Http\Controllers\Pages\ActivityProgressController::class, 'index']);

    });

    Route::middleware('activity')->group(function () {
        Route::middleware('administrator')->get('/a/{activity_slug}', [ActivityController::class, 'administrator'])->name('administrator.activity');
        Route::middleware('participant')->get('/p/{activity_slug}', [ActivityController::class, 'participant'])->name('participant.activity');
    });

    Route::middleware('activity')->group(function () {
        Route::middleware('administrator')->get('/a/{activity_slug}', [ActivityController::class, 'administrator'])->name('administrator.activity');
        Route::middleware('participant')->get('/p/{activity_slug}', [ActivityController::class, 'participant'])->name('participant.activity');
    });

});
