<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Activity\Contracts\Repository;
use BristolSU\Support\User\Contracts\UserAuthentication;
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
            'user_id' => app(UserAuthentication::class)->getUser()->controlId()
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
}
