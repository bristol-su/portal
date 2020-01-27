<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Action\ActionInstanceField;
use Illuminate\Http\Request;

/**
 * Manage the field mappings for an action instance
 */
class ActionInstanceFieldController extends Controller
{

    /**
     * Create a new field mapping from an event field to an action field
     *
     * Accepts
     * [
     *      'event_field' => 'event_field',
     *      'action_field' => 'action_field',
     *      'action_instance_id' => 1 // Action instance the mapping should apply to
     * ]
     *
     * @param Request $request Request Object
     * @return ActionInstanceField
     */
    public function store(Request $request)
    {
        return ActionInstanceField::create($request->only([
            'event_field', 'action_field', 'action_instance_id'
        ]));
    }

    /**
     * Update an action instance field mapping
     *
     * Accepts
     * [
     *      'event_field' => 'event_field',
     *      'action_field' => 'action_field',
     *      'action_instance_id' => 1 // Action instance the mapping should apply to
     * ]
     *
     * @param ActionInstanceField $actionInstanceField Field mapping to update
     * @param Request $request Request object
     * @return ActionInstanceField Updated action instance
     */
    public function update(ActionInstanceField $actionInstanceField, Request $request)
    {
        $actionInstanceField->fill($request->only([
            'event_field', 'action_field', 'action_instance_id'
        ]));
        $actionInstanceField->save();
        return $actionInstanceField;
    }
}
