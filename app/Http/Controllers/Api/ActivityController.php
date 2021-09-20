<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\Authentication\Contracts\Authentication;
use Illuminate\Http\Request;

/**
 * Manage activities
 */
class ActivityController extends Controller
{

    /**
     * Create a new Activity
     *
     * Accepts
     * - name: Name for the activity
     * - description: Description for the activity
     * - slug: Slug the activity can be accessed at
     * - type: Open, Completable or Multi-Completable
     * - activity_for: user, group, or role
     * - for_logic: ID of a logic group to use for for logic
     * - admin_logic: ID of a logic group to use for admin logic
     * - start_date: Date the activity becomes active, or null if always active
     * - end_date: Date the activity stops being active, or null if always active
     *
     * @param Request $request Request Object
     * @param Repository $repository Repository to create the activity with
     * @return \BristolSU\Support\Activity\Activity Created Activity
     */
    public function store(Request $request, Repository $repository)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'type' => 'required',
            'activity_for' => 'required',
            'for_logic' => 'required',
            'admin_logic' => 'required',
            'start_date' => 'sometimes|nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'sometimes|nullable|date_format:Y-m-d H:i:s'
        ]);

        return $repository->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'slug' => $request->input('slug'),
            'type' => $request->input('type'),
            'activity_for' => $request->input('activity_for'),
            'for_logic' => $request->input('for_logic'),
            'admin_logic' => $request->input('admin_logic'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => app(Authentication::class)->getUser()->id()
        ]);
    }

    /**
     * Update an Activity
     *
     * Accepts
     * - name: Name for the activity
     * - description: Description for the activity
     * - slug: Slug the activity can be accessed at
     *
     * @param Activity $activity
     * @param Request $request Request Object
     * @param Repository $repository Repository to create the activity with
     * @return \BristolSU\Support\Activity\Activity Created Activity
     */
    public function update(Activity $activity, Request $request, Repository $repository)
    {
        return $repository->update($activity->id, $request->only([
            'name', 'description', 'enabled', 'start_date', 'end_date', 'admin_logic', 'for_logic'
        ]));
    }

    /**
     * @param Activity $activity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Activity $activity)
    {
        $this->authorize('view-management');
        $activity->delete();
        return response($activity);
    }
}
