<?php

namespace App\Console\Commands;

use BristolSU\Support\Action\ActionInstance;
use BristolSU\Support\Action\ActionInstanceField;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\Completion\CompletionConditionInstance;
use BristolSU\Support\Logic\Logic;
use BristolSU\Support\ModuleInstance\Connection\ModuleInstanceService;
use BristolSU\Support\ModuleInstance\ModuleInstance;
use BristolSU\Support\ModuleInstance\ModuleInstanceGrouping;
use BristolSU\Support\ModuleInstance\Settings\ModuleInstanceSetting;
use BristolSU\Support\Permissions\Models\ModuleInstancePermission;
use Illuminate\Console\Command;

class DuplicateActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:duplicate {activity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Duplicate an activity';

    private array $newLogics = [];

    private array $moduleGroups = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $activity = Activity::findOrFail($this->argument('activity'));

        $newActivity = Activity::make($activity->toArray());
        $newActivity->slug = $activity->slug . '-copy';
        $newActivity->name = $activity->name . ' (copy)';
        $newActivity->for_logic = $this->getDuplicatedLogic($activity->forLogic)->id;
        $newActivity->admin_logic = $this->getDuplicatedLogic($activity->adminLogic)->id;
        $newActivity->enabled = false;
        $newActivity->save();

        foreach($activity->moduleGrouping as $group) {
            $newGroup = ModuleInstanceGrouping::make($group->toArray());
            $newGroup->activity_id = $newActivity->id;
            $newGroup->save();
            $this->moduleGroups[$group->id] = $newGroup;
        }

        foreach($activity->moduleInstances as $module) {
            $newModule = ModuleInstance::make($module->toArray());
            $newModule->name = $module->name . ' (copy)';
            $newModule->slug = $module->slug . '-copy';
            $newModule->active = $this->getDuplicatedLogic($module->activeLogic)->id;
            $newModule->visible = $this->getDuplicatedLogic($module->visibleLogic)->id;
            $newModule->activity_id = $newActivity->id;
            if($module->mandatory !== null) {
                $newModule->mandatory = $this->getDuplicatedLogic($module->mandatoryLogic)->id;
            }
            if($module->completion_condition_instance_id !== null) {
                $newCompletionCondition = CompletionConditionInstance::make($module->completionConditionInstance->toArray());
                $newCompletionCondition->name = $newCompletionCondition->name . ' (copy)';
                $newCompletionCondition->save();
                $newModule->completion_condition_instance_id = $newCompletionCondition->id;
            }
            if($module->grouping_id !== null) {
                $newModule->grouping_id = $this->moduleGroups[$module->groupingId] ?? null;
            }
            $newModule->save();

            foreach($module->moduleInstanceServices as $service) {
                $newService = ModuleInstanceService::make($service->toArray());
                $newService->module_instance_id = $newModule->id;
                $newService->save();
            }

            foreach($module->moduleInstancePermissions as $permission) {
                $newPermission = ModuleInstancePermission::make($permission->toArray());
                $newPermission->module_instance_id = $newModule->id;
                $newPermission->logic_id  = $this->getDuplicatedLogic($permission->logic)->id;
                $newPermission->save();
            }

            foreach($module->moduleInstanceSettings as $setting) {
                $newSetting = ModuleInstanceSetting::make($setting->toArray());
                $newSetting->module_instance_id = $newModule->id;
                $newSetting->save();
            }

            foreach($module->actionInstances as $actionInstance) {
                $newActionInstance = ActionInstance::make($actionInstance->toArray());
                $newActionInstance->module_instance_id = $newModule->id;
                $newActionInstance->save();

                foreach($actionInstance->actionInstanceFields as $field) {
                    $newField = ActionInstanceField::make($field->toArray());
                    $newField->action_instance_id = $newActionInstance->id;
                    $newField->save();
                }
            }

        }

        $this->line('Created activity ' . $newActivity->id);

        return Command::SUCCESS;
    }

    private function getDuplicatedLogic(Logic $logic): Logic
    {
        if(!array_key_exists($logic->id, $this->newLogics)) {
            $this->newLogics[$logic->id] = $this->duplicateLogic($logic);
        }
        return $this->newLogics[$logic->id];
    }

    private function duplicateLogic(Logic $logic): Logic
    {
        $newLogic = Logic::make($logic->toArray());
        $newLogic->name = $logic->name . ' (Copy)';
        $newLogic->save();
        // TODO Fire logic testers?
        return $newLogic;
    }
}
