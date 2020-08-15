<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\DataGroup as DataGroupModel;
use BristolSU\ControlDB\Contracts\Repositories\DataGroup as DataGroupRepository;
use BristolSU\ControlDB\Contracts\Repositories\Group as ControlGroupRepository;
use BristolSU\ControlDB\Contracts\Models\DataRole as DataRoleModel;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Role as ControlRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Contracts\Models\DataUser as DataUserModel;
use BristolSU\ControlDB\Contracts\Repositories\User as ControlUserRepository;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Manages Activity Instances
 */
class ActivityInstanceSearchController extends Controller
{

    public function search(Activity $activity, Request $request, ActivityInstanceRepository $activityInstanceRepository) {
        $request->validate([
            'query' => 'required|string'
        ]);

        $controlIds = new Collection();

        switch($activity->activity_for) {
            case 'user':
                $dataUserRepository = app(DataUserRepository::class);
                $dataUserIds = (new Collection([
                    $dataUserRepository->getAllWhere(['first_name' => $request->input('query')]),
                    $dataUserRepository->getAllWhere(['last_name' => $request->input('query')]),
                    $dataUserRepository->getAllWhere(['preferred_name' => $request->input('query')]),
                    $dataUserRepository->getAllWhere(['email' => $request->input('query')])
                ]))->flatten(1)->unique(function(DataUserModel $dataUser) {
                    return $dataUser->id();
                })->pluck('id');
                $controlUserRepository = app(ControlUserRepository::class);
                $controlIds = $dataUserIds->map(function($id) use ($controlUserRepository) {
                    return $controlUserRepository->getByDataProviderId($id)->id();
                });
                break;
            case 'group':
                $dataGroupRepository = app(DataGroupRepository::class);
                $dataGroupIds = (new Collection([
                    $dataGroupRepository->getAllWhere(['name' => $request->input('query')]),
                    $dataGroupRepository->getAllWhere(['email' => $request->input('query')]),
                ]))->flatten(1)->unique(function(DataGroupModel $dataGroup) {
                    return $dataGroup->id();
                })->pluck('id');
                $controlGroupRepository = app(ControlGroupRepository::class);
                $controlIds = $dataGroupIds->map(function($id) use ($controlGroupRepository) {
                    return $controlGroupRepository->getByDataProviderId($id)->id();
                });
                break;
            case 'role':
                $dataRoleRepository = app(DataRoleRepository::class);
                $dataRoleIds = (new Collection([
                    $dataRoleRepository->getAllWhere(['role_name' => $request->input('query')]),
                    $dataRoleRepository->getAllWhere(['email' => $request->input('query')]),
                ]))->flatten(1)->unique(function(DataRoleModel $dataRole) {
                    return $dataRole->id();
                })->pluck('id');
                $controlRoleRepository = app(ControlRoleRepository::class);
                $controlIds = $dataRoleIds->map(function($id) use ($controlRoleRepository) {
                    return $controlRoleRepository->getByDataProviderId($id)->id();
                });
                break;
            default:
                throw new Exception(
                    sprintf('The activity type must be one of user group or role, %s given', $activity->activity_for)
                );
        }
        // Search for matching models
        return $controlIds->map(function($controlId) use ($activityInstanceRepository, $activity) {
            return $activityInstanceRepository->allFor($activity->id, $activity->activity_for, $controlId);
        })->flatten(1)->unique('id')->pluck('id')->values()->toArray();
    }



}
