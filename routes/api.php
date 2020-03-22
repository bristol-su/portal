<?php

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
Route::middleware(['auth', 'verified', 'can:view-management'])->group(function() {
    Route::apiResource('activity', 'ActivityController')->only(['store', 'update']);
    Route::apiResource('setting', 'SettingController')->only(['index', 'show', 'update']);
    Route::apiResource('filter', 'FilterController')->only(['index']);
    Route::apiResource('filter-instances', 'FilterInstanceController')->only(['store']);
    Route::apiResource('logic', 'LogicController')->only(['index', 'show', 'store']);
    Route::apiResource('module', 'ModuleController')->only(['index', 'show']);
    Route::apiResource('module-instance-permission', 'ModuleInstancePermissionController')->only(['show', 'store', 'update']);
    Route::apiResource('module-instance-service', 'ModuleInstanceServiceController')->only(['show', 'store', 'update', 'index']);
    Route::apiResource('module-instance-setting', 'ModuleInstanceSettingController')->only(['show', 'store', 'update']);
    Route::apiResource('module-instance', 'ModuleInstanceController')->only(['store', 'update']);
    Route::apiResource('action', 'ActionController')->only(['index']);
    Route::apiResource('action-instance', 'ActionInstanceController')->only(['store', 'update']);
    Route::apiResource('action-instance-field', 'ActionInstanceFieldController')->only(['store', 'update']);
    Route::apiResource('site-permission', 'SitePermissionController')->only('index', 'show');
    Route::apiResource('connector', 'ConnectorController')->only('index', 'show');
    Route::apiResource('connection', 'ConnectionController')->only('index', 'destroy', 'update', 'store');
    Route::get('connection/{connection_id}/test', 'ConnectionController@test');
    Route::apiResource('completion-condition-instance', 'CompletionConditionInstanceController')->only(['store', 'update']);
    Route::apiResource('activity-instance', 'ActivityInstanceController')->only(['store']);
    Route::get('/activity/{activity}/progress', 'ActivityProgressController@show');

    Route::prefix('/module/{module_alias}')->group(function() {
        Route::get('completion-condition/{completion_condition_alias}', 'CompletionConditionController@show');
        Route::get('completion-condition', 'CompletionConditionController@index');
    });

    Route::namespace('Relationships')->group(function() {
        Route::get('/activity/{activity}/module-instance', 'ActivityModuleInstancesController@index');

        Route::get('service/{service}/connection', 'ServiceConnectionController@index');

        Route::get('/logic/{logic}/filters', 'LogicFiltersController@index');
        Route::get('/logic/{logic}/audience', 'LogicAudienceController@index');
        Route::get('/logic/{logic}/audience/user', 'LogicAudienceController@user');
        Route::get('/logic/{logic}/audience/group', 'LogicAudienceController@group');
        Route::get('/logic/{logic}/audience/role', 'LogicAudienceController@role');

        Route::get('/me/roles', 'MeRolesController@index');

        Route::get('/site-permission/{site_permission}/user', 'SitePermissionUserController@index');
        Route::post('/site-permission/{site_permission}/user/{control_user_id}', 'SitePermissionUserController@store');
        Route::delete('/site-permission/{site_permission}/user/{control_user_id}', 'SitePermissionUserController@delete');

        Route::prefix('/module-instance/{module_instance_id}')->group(function() {
            Route::apiResource('module-instance-setting', 'ModuleInstanceModuleInstanceSettingController')->only(['index']);
            Route::apiResource('module-instance-permission', 'ModuleInstanceModuleInstancePermissionController')->only(['index']);
            Route::apiResource('module-instance-service', 'ModuleInstanceModuleInstanceServiceController')->only(['index']);
        });

    });

});
