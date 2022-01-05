<?php

namespace App\Http\View\Sidebar;

use App\Http\Middleware\MarkAsManagement;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Support\Activity\Contracts\Repository as ActivityRepository;
use BristolSU\Support\ActivityInstance\Contracts\ActivityInstanceResolver;
use BristolSU\Support\Authentication\AuthQuery\Generator;
use BristolSU\Support\Authentication\Contracts\Authentication;
use BristolSU\Support\ModuleInstance\Contracts\Evaluator\ModuleInstanceEvaluator;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use BristolSU\Support\Permissions\Facade\PermissionTester;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SidebarComposer
{
    /**
     * @var Authentication
     */
    private Authentication $authentication;

    private Request $request;
    private ModuleInstance $moduleInstance;
    private ModuleInstanceEvaluator $evaluator;
    private ActivityInstanceResolver $activityInstanceResolver;

    /**
     * @param Request $request
     * @param Authentication $authentication
     * @param ModuleInstance $moduleInstance
     * @param ModuleInstanceEvaluator $evaluator
     * @param ActivityInstanceResolver $activityInstanceResolver
     */
    public function __construct(Request $request, Authentication $authentication, ModuleInstance $moduleInstance, ModuleInstanceEvaluator $evaluator, ActivityInstanceResolver $activityInstanceResolver)
    {
        $this->authentication = $authentication;
        $this->request = $request;
        $this->moduleInstance = $moduleInstance;
        $this->evaluator = $evaluator;
        $this->activityInstanceResolver = $activityInstanceResolver;
    }

    public function compose(View $view)
    {
        if ($this->authentication->hasUser() && !app('router')->is(['verify.notice', 'password.confirmation.notice'])) {
            $isAdmin = $this->request->is(['a', 'a/*']);
            if (MarkAsManagement::$isManagement) {
                $view->with('sidebarSchema', $this->getManagementSidebar());
            } elseif ($this->moduleInstance->exists) {
                $view->with('sidebarSchema', $this->getModuleSidebar($isAdmin));
            } else {
                $view->with('sidebarSchema', $this->getBasicSidebar($isAdmin));
            }

            $subtitle = '';
            if($this->authentication->hasRole()) {
                $subtitle = sprintf('%s for %s', $this->authentication->getRole()->data()->roleName(), $this->authentication->getRole()->group()->data()->name());
            }
            elseif($this->authentication->hasGroup()) {
                $subtitle = sprintf('Membership to %s', $this->authentication->getGroup()->data()->name());
            }
//            elseif($this->authentication->hasUser()) {
//                $subtitle = sprintf('Personal');
//            }
            $view->with('subtitle', $subtitle);
        }
    }

    private function getManagementSidebar()
    {
        return [
            ['title' => 'Manage Activities', 'route' => route('activity.index'), 'icon' => 'fa fa-th-list'],
            ['title' => 'View Logic', 'route' => route('logic.index'), 'icon' => 'fa fa-users'],
            ['title' => 'Create Logic', 'route' => route('logic.create'), 'icon' => 'fa fa-user-plus'],
            ['title' => 'Connectors', 'route' => route('connector.index'), 'icon' => 'fa fa-link'],
            ['title' => 'Settings', 'route' => route('settings.index'), 'icon' => 'fa fa-cogs'],
        ];
    }

    private function getModuleSidebar(bool $isAdmin = false): array
    {
        $schema = [];
        $activity = $this->moduleInstance->activity;
        $schema[] = [
            'title' => 'Back to ' . $activity->name,
            'route' => route('participant.activity', array_merge(['activity_slug' => $activity->slug], app(Generator::class)->getAuthCredentials()->toArray())),
            'icon' => 'fa fa-arrow-left'
        ];
        $activity->moduleInstances->each(function (ModuleInstance $moduleInstance) use (&$schema, $isAdmin, $activity) {
            $evaluation = $isAdmin
                ? $this->evaluator->evaluateAdministrator($moduleInstance, $this->authentication->getUser(), $this->authentication->getGroup(), $this->authentication->getRole())
                : $this->evaluator->evaluateParticipant(
                    $this->activityInstanceResolver->getActivityInstance(),
                    $moduleInstance,
                    $this->authentication->getUser(),
                    $this->authentication->getGroup(),
                    $this->authentication->getRole()
                );
            if ($evaluation->visible() && $evaluation->active()) {
                $schema[] = [
                    'title' => $moduleInstance->name,
                    'route' => sprintf('/%s/%s/%s/%s?%s', $isAdmin ? 'a' : 'p', $activity->slug, $moduleInstance->slug, $moduleInstance->alias(), url()->getAuthQueryString()),
                    'icon' => $evaluation->complete() ? 'fa fa-check' : 'fa fa-arrow-right',
                    'highlight' => $evaluation->mandatory()
                ];
            }
        });

        if(PermissionTester::evaluate('view-management')) {
            $schema[] = [
                'title' => 'Edit Page',
                'route' => route('management.module-instance.show', ['activity' => $activity, 'module_instance' => $this->moduleInstance]),
                'icon' => 'fa fa-pencil'
            ];
        }
        return $schema;
    }

    private function getBasicSidebar(bool $isAdmin): array
    {
        $schema = [];

        $schema[] = ['title' => 'Dashboard', 'route' => route($isAdmin ? 'administrator' : 'participant'), 'icon' => 'fa fa-home'];

        if ($this->canBeAdmin()) {
            $schema[] = [
                'title' => sprintf('Go to %s', ($isAdmin ? 'participant' : 'admin')),
                'route' => sprintf('/%s', ($isAdmin ? 'p' : 'a')),
                'icon' => sprintf('fa fa-%s', $isAdmin ? 'user' : 'user-shield')
            ];
        }

        return $schema;
    }

    private function canBeAdmin(): bool
    {
        /** @var Authentication $authentication */
        $authentication = app(Authentication::class);

        /** @var ActivityRepository $activityRepository */
        $activityRepository = app(ActivityRepository::class);

        $user = $authentication->getUser();
        if ($activityRepository->getForAdministrator($user)->count() > 0) {
            return true;
        }

        foreach ($user->groups() as $group) {
            if ($activityRepository->getForAdministrator($user, $group)->count() > 0) {
                return true;
            }
        }

        foreach ($user->roles() as $role) {
            if ($activityRepository->getForAdministrator($user, $role->group(), $role)->count() > 0) {
                return true;
            }
        }

        return false;
    }
}
