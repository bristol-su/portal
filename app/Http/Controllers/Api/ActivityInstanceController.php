<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use Illuminate\Http\Request;

/**
 * Manages Activity Instances
 */
class ActivityInstanceController extends Controller
{

    /**
     * Create an activity instance
     *
     * Accepts
     * - activity_id: The ID of the activity the activity instance is of
     * - resource_type: The type of resource, user, group or role
     * - resource_id: The ID of the resource the activity instance is for
     * - name: The name of the activity instance
     * - description: The description of the activity instance
     *
     * @param Request $request Request object
     * @param ActivityInstanceRepository $repository The repository to use to create the activity instance
     * @return \BristolSU\Support\ActivityInstance\ActivityInstance Created Activity Instance
     */
    public function store(Request $request, ActivityInstanceRepository $repository) {
        return $repository->create(
            $request->input('activity_id'),
            $request->input('resource_type'),
            $request->input('resource_id'),
            $request->input('name'),
            $request->input('description')
        );
    }



}
