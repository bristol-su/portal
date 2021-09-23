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


Route::middleware(['portal-auth'])->group(function () {

    Route::apiResource('whoami', \App\Http\Controllers\Api\WhoAmIController::class)->only(['index']);

    Route::get('owned-resource', [\App\Http\Controllers\Api\Portal\OwnedResourceController::class, 'index']);

    // Retrieve activities for a specific user/group/role combo
    Route::get('activity/role', [\App\Http\Controllers\Api\Portal\ActivityParticipantController::class, 'role']);
    Route::get('activity/group', [\App\Http\Controllers\Api\Portal\ActivityParticipantController::class, 'group']);
    Route::get('activity/user', [\App\Http\Controllers\Api\Portal\ActivityParticipantController::class, 'user']);

    Route::get('activity/admin/role', [\App\Http\Controllers\Api\Portal\ActivityAdminController::class, 'role']);
    Route::get('activity/admin/group', [\App\Http\Controllers\Api\Portal\ActivityAdminController::class, 'group']);
    Route::get('activity/admin/user', [\App\Http\Controllers\Api\Portal\ActivityAdminController::class, 'user']);

    // Retrieve evaluation of activity for the activity resource
    Route::get('activity/{activity}/evaluate/resource', [\App\Http\Controllers\Api\Portal\ActivityEvaluationController::class, 'resource']);
    Route::get('activity/{activity}/evaluate/participant', [\App\Http\Controllers\Api\Portal\ActivityEvaluationController::class, 'participant']);
    Route::get('activity/{activity}/evaluate/admin', [\App\Http\Controllers\Api\Portal\ActivityEvaluationController::class, 'admin']);

    // Retrieve evaluation of module instances
    Route::get('activity/{activity}/module-instance/evaluate/resource', [\App\Http\Controllers\Api\Portal\ModuleInstanceEvaluationController::class, 'resource']);
    Route::get('activity/{activity}/module-instance/evaluate', [\App\Http\Controllers\Api\Portal\ModuleInstanceEvaluationController::class, 'participant']);
    Route::get('activity/{activity}/module-instance/admin/evaluate', [\App\Http\Controllers\Api\Portal\ModuleInstanceEvaluationController::class, 'admin']);



    Route::middleware(['can:view-management'])->group(function () {
        Route::apiResource('activity', \App\Http\Controllers\Api\ActivityController::class)->only(['store', 'update']);
        Route::apiResource('filter', \App\Http\Controllers\Api\FilterController::class)->only(['index']);
        Route::apiResource('filter-instances', \App\Http\Controllers\Api\FilterInstanceController::class)->only(['store']);
        Route::apiResource('logic', \App\Http\Controllers\Api\LogicController::class, ['as' => 'logic'])->only(['index', 'show', 'store', 'update']);
        Route::apiResource('module', \App\Http\Controllers\Api\ModuleController::class)->only(['index', 'show']);
        Route::apiResource('module-instance-permission', \App\Http\Controllers\Api\ModuleInstancePermissionController::class)->only(['show', 'store', 'update', 'destroy']);
        Route::apiResource('module-instance-service', \App\Http\Controllers\Api\ModuleInstanceServiceController::class, ['as' => 'service'])->only(['show', 'store', 'update', 'index']);
        Route::apiResource('module-instance-setting', \App\Http\Controllers\Api\ModuleInstanceSettingController::class)->only(['show', 'store', 'update']);
        Route::apiResource('module-instance', \App\Http\Controllers\Api\ModuleInstanceController::class)->only(['store', 'update']);
        Route::get('module-instance-grouping', [\App\Http\Controllers\Api\ModuleInstanceGroupingController::class, 'index']);
        Route::post('module-instance-grouping', [\App\Http\Controllers\Api\ModuleInstanceGroupingController::class, 'store']);
        Route::apiResource('action', \App\Http\Controllers\Api\ActionController::class)->only(['index']);
        Route::apiResource('action-instance', \App\Http\Controllers\Api\ActionInstanceController::class)->only(['store', 'update']);
        Route::apiResource('action-instance-field', \App\Http\Controllers\Api\ActionInstanceFieldController::class)->only(['store', 'update']);
        Route::apiResource('site-permission', \App\Http\Controllers\Api\SitePermissionController::class, ['as' => 'site-permission'])->only('index', 'show');
        Route::apiResource('connector', \App\Http\Controllers\Api\ConnectorController::class, ['as' => 'connector'])->only('index', 'show');
        Route::apiResource('connection', \App\Http\Controllers\Api\ConnectionController::class)->only('index', 'destroy', 'update', 'store');
        Route::get('connection/{connection_id}/test', [\App\Http\Controllers\Api\ConnectionController::class, 'test']);
        Route::apiResource('completion-condition-instance', \App\Http\Controllers\Api\CompletionConditionInstanceController::class)->only(['store', 'update']);
        Route::apiResource('activity-instance', \App\Http\Controllers\Api\ActivityInstanceController::class)->only(['store', 'show']);
        Route::get('/activity/{activity}/progress', [\App\Http\Controllers\Api\ActivityProgressController::class, 'index']);
        Route::post('/activity/{activity}/progress/snapshot', [\App\Http\Controllers\Api\ActivityProgressSnapshotController::class, 'store']);
        Route::post('/activity/{activity}/activity-instance/search', [\App\Http\Controllers\Api\ActivityInstanceSearchController::class, 'search']);
        Route::get('/progress/activity-instance/{activity_instance}', [\App\Http\Controllers\Api\ActivityInstanceProgressController::class, 'index']);

        Route::apiResource('module-instance-grouping', \App\Http\Controllers\Api\ModuleInstanceGroupingController::class)->only([
            'index', 'store', 'update'
        ]);
        Route::post('module-instance-grouping/{module_instance_grouping}/order/up', [\App\Http\Controllers\Api\ModuleInstanceGroupingOrderController::class, 'up']);
        Route::post('module-instance-grouping/{module_instance_grouping}/order/down', [\App\Http\Controllers\Api\ModuleInstanceGroupingOrderController::class, 'down']);
        Route::post('module-instance/{module_instance}/order/up', [\App\Http\Controllers\Api\ModuleInstanceOrderController::class, 'up']);
        Route::post('module-instance/{module_instance}/order/down', [\App\Http\Controllers\Api\ModuleInstanceOrderController::class, 'down']);


        Route::prefix('/module/{module_alias}')->group(function () {
            Route::get('completion-condition/{completion_condition_alias}', [\App\Http\Controllers\Api\CompletionConditionController::class, 'show']);
            Route::get('completion-condition', [\App\Http\Controllers\Api\CompletionConditionController::class, 'index']);
        });

        Route::prefix('/action-instance/{action_instance}')->group(function () {
            Route::get('action-instance-field', [\App\Http\Controllers\Api\Relationships\ActionInstanceActionInstanceFieldController::class, 'index']);
            Route::get('history', [\App\Http\Controllers\Api\Relationships\ActionInstanceActionInstanceHistoryController::class, 'index']);
        });

        Route::prefix('logic/{logic}')->group(function () {
            Route::resource('filter-instance', \App\Http\Controllers\Api\Relationships\LogicFilterInstanceController::class)->only(['index', 'update', 'destroy']);
        });

        Route::get('/activity/{activity}/module-instance', [\App\Http\Controllers\Api\Relationships\ActivityModuleInstancesController::class, 'index']);

        Route::get('service/{service}/connection', [\App\Http\Controllers\Api\Relationships\ServiceConnectionController::class, 'index']);

        Route::get('/logic/{logic}/audience', [\App\Http\Controllers\Api\Relationships\LogicAudienceController::class, 'index']);
        Route::get('/logic/{logic}/audience/user', [\App\Http\Controllers\Api\Relationships\LogicAudienceController::class, 'user']);
        Route::get('/logic/{logic}/audience/group', [\App\Http\Controllers\Api\Relationships\LogicAudienceController::class, 'group']);
        Route::get('/logic/{logic}/audience/role', [\App\Http\Controllers\Api\Relationships\LogicAudienceController::class, 'role']);

        Route::get('/me/roles', [\App\Http\Controllers\Api\Relationships\MeRolesController::class, 'index']);

        Route::get('/site-permission/{site_permission}/user', [\App\Http\Controllers\Api\Relationships\SitePermissionUserController::class, 'index']);
        Route::post('/site-permission/{site_permission}/user/{control_user_id}', [\App\Http\Controllers\Api\Relationships\SitePermissionUserController::class, 'store']);
        Route::delete('/site-permission/{site_permission}/user/{control_user_id}', [\App\Http\Controllers\Api\Relationships\SitePermissionUserController::class, 'delete']);

        Route::prefix('/module-instance/{module_instance_id}')->group(function () {
            Route::apiResource('module-instance-setting', \App\Http\Controllers\Api\Relationships\ModuleInstanceModuleInstanceSettingController::class)->only(['index']);
            Route::apiResource('module-instance-permission', \App\Http\Controllers\Api\Relationships\ModuleInstanceModuleInstancePermissionController::class)->only(['index']);
            Route::apiResource('module-instance-service', \App\Http\Controllers\Api\Relationships\ModuleInstanceModuleInstanceServiceController::class)->only(['index']);
        });

        Route::apiResource('setting', \App\Http\Controllers\Api\SettingController::class)->only(['show', 'update']);

    });

});
