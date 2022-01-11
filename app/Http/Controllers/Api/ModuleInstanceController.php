<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ModuleInstanceController\StoreModuleInstanceRequest;
use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Completion\Contracts\CompletionConditionInstanceRepository;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Http\Request;

class ModuleInstanceController extends Controller
{

    public function store(StoreModuleInstanceRequest $request, ModuleInstanceRepository $moduleInstanceRepo, CompletionConditionInstanceRepository $conditionInstanceRepository)
    {
        $completionConditionInstance = null;
        if(app(Repository::class)->getById($request->input('activity_id'))->isCompletable()) {
            $completionConditionInstance = $conditionInstanceRepository->create([
                'name' => $request->input('completion_condition_name', 'Completion Condition'),
                'alias' => $request->input('completion_condition_alias'),
                'settings' => $request->input('completion_condition_settings')
            ]);
        }

        return $moduleInstanceRepo->create(array_merge($request->only([
            'alias', 'activity_id', 'name', 'description', 'slug', 'active', 'visible', 'mandatory',
            'order', 'grouping_id'
        ]), ['user_id' => app(Authentication::class)->getUser()->id(), 'completion_condition_instance_id' => $completionConditionInstance?->id]));
    }

    public function update(StoreModuleInstanceRequest $moduleInstance, Request $request, ModuleInstanceRepository $repository, CompletionConditionInstanceRepository $cc)
    {
        if(app(Repository::class)->getById($request->input('activity_id'))->isCompletable()) {
            $cc->update($moduleInstance->completionConditionInstance->id, [
                'name' => $request->input('completion_condition_name', $moduleInstance->completionConditionInstance->name),
                'alias' => $request->input('completion_condition_alias', $moduleInstance->completionConditionInstance->alias),
                'settings' => $request->input('completion_condition_settings', $moduleInstance->completionConditionInstance->settings)
            ]);
        }

        return $repository->update($moduleInstance->id(), $request->only([
            'name', 'description', 'enabled', 'active', 'visible', 'mandatory',
            'order', 'grouping_id'
        ]));
    }

    /**
     * @param ModuleInstance $moduleInstance
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(ModuleInstance $moduleInstance)
    {
        $this->authorize('view-management');
        $moduleInstance->delete();
        return response()->json($moduleInstance);
    }

}
