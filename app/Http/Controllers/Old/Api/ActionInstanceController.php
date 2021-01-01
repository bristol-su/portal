<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstance;
use BristolSU\Support\Authentication\Contracts\Authentication;
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
     * @param Authentication $authentication
     * @return ActionInstance
     */
    public function store(Request $request, Authentication $authentication)
    {
        return ActionInstance::create(array_merge($request->only([
            'name', 'description', 'event', 'action', 'module_instance_id', 'should_queue'
        ]), ['user_id' => $authentication->getUser()->id()]));
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
}
