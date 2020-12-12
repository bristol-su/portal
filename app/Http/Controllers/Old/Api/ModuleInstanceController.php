<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ModuleInstanceController\StoreModuleInstanceRequest;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\ModuleInstanceRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Http\Request;

class ModuleInstanceController extends Controller
{

    public function store(StoreModuleInstanceRequest $request, ModuleInstanceRepository $moduleInstanceRepo, Authentication $authentication)
    {
        return $moduleInstanceRepo->create(array_merge($request->only([
            'alias', 'activity_id', 'name', 'description', 'slug', 'active', 'visible', 'mandatory',
            'completion_condition_instance_id'
        ]), ['user_id' => $authentication->getUser()->id()]));
    }

    public function update(ModuleInstance $moduleInstance, Request $request, ModuleInstanceRepository $repository)
    {
        return $repository->update($moduleInstance->id(), $request->only([
            'name', 'description', 'enabled', 'active', 'visible', 'mandatory', 'completion_condition_instance_id'
        ]));
    }

}
