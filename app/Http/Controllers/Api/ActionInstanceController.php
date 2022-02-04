<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstance;
use BristolSU\Support\Action\ActionInstanceField;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\Module\Contracts\ModuleRepository;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use Illuminate\Http\Request;

/**
 * Manage actions that will fire when events fire
 */
class ActionInstanceController extends Controller
{

    /**
     * Create a new action instance
     *
     * Accepts:
     * [
     *      'name' => 'Name',
     *      'description' => 'Description',
     *      'event' => '\Fully\Namespaced\EventClass',
     *      'action' => '\Fully\Namespaced\ActionClass',
     *      'module_instance_id => 1 // ID of the module instace that should fire the event
     * ]
     *
     * @param Request $request Request object with the given parameters
     * @return ActionInstance
     */
    public function store(Request $request)
    {
        return ActionInstance::create(array_merge($request->only([
            'name', 'description', 'event', 'action', 'module_instance_id', 'should_queue'
        ]), ['user_id' => app(Authentication::class)->getUser()->id()]));
    }

    /**
     * Update an action instance
     *
     * Accepts:
     * [
     *      'name' => 'Name',
     *      'description' => 'Description',
     *      'event' => '\Fully\Namespaced\EventClass',
     *      'action' => '\Fully\Namespaced\ActionClass',
     *      'module_instance_id => 1 // ID of the module instace that should fire the event
     * ]
     *
     * @param ActionInstance $actionInstance Action instance to update
     * @param Request $request Request object with the given parameters
     * @return ActionInstance Updated action instance
     */
    public function update(ActionInstance $actionInstance, Request $request)
    {
        $actionInstance->fill($request->only([
            'name', 'description', 'event', 'action', 'module_instance_id', 'should_queue'
        ]));
        $actionInstance->save();
        return $actionInstance;
    }

    /**
     * Show information about a specific action instance
     *
     * @param ActionInstance $actionInstance Action instance to show
     * @return ActionInstance Given action instance
     */
    public function show(ActionInstance $actionInstance)
    {
        return $actionInstance;
    }

    public function destroy(ActionInstance $actionInstance)
    {
        $actionInstance->delete();

        return response('', 204);
    }

    public function setMany(ActionInstance $actionInstance, Request $request)
    {
        $request->validate([
            'data' => 'required|array'
        ]);

        foreach($request->input('data') as $key => $value) {
            if($value === null) {
                ActionInstanceField::where(
                    ['action_instance_id' => $actionInstance->id, 'action_field' => $key],
                )->delete();
            } else {
                ActionInstanceField::updateOrCreate(
                    ['action_instance_id' => $actionInstance->id, 'action_field' => $key],
                    ['action_value' => $value]
                );
            }
        }

        return response('', 204);
    }

}
