<?php

use Illuminate\Database\Seeder;

class ExampleActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a logic group

        $users = app(\BristolSU\ControlDB\Contracts\Repositories\User::class)->all();
        if($users->count() === 0) {
            throw new \Exception('No user created. Please register before running the seeder.');
        } else {
            $user = $users->first();
        }

        try {
            $logic = \BristolSU\Support\Logic\Logic::where('name', 'All Users')->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $logic = app(\BristolSU\Support\Logic\Contracts\LogicRepository::class)
                ->create([
                    'name' => 'All Users',
                    'description' => 'A logic group that contains all users'
                ]);
        }

        try {
            $activity = \BristolSU\Support\Activity\Activity::where('slug', 'example-activity')->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $activity = \BristolSU\Support\Activity\Activity::create([
                'name' => 'Example Activity',
                'description' => 'An example activity for seeing what the portal can do',
                'activity_for' => 'user',
                'for_logic' => $logic->id,
                'admin_logic' => $logic->id,
                'start_date' => null,
                'end_date' => null,
                'slug' => 'example-activity',
                'type' => 'multi-completable',
                'enabled' => true,
                'user_id' => $user->id
            ]);
        }

        $grouping = \BristolSU\Support\ModuleInstance\ModuleInstanceGrouping::create(['heading' => 'Examples']);
        $completionConditionInstance = \BristolSU\Support\Completion\CompletionConditionInstance::create([
            'alias' => 'static_page_has_submitted',
            'name' => 'Submit button pressed.',
            'settings' => [],
            'description' => 'This module will be marked as complete once the submit button has been pressed.'
        ]);

        try {
            $module = \BristolSU\Support\ModuleInstance\ModuleInstance::where('slug', 'example-module')->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $module = \BristolSU\Support\ModuleInstance\ModuleInstance::create([
                'alias' => 'static-page',
                'activity_id' => $activity->id,
                'name' => 'Example Module',
                'slug' => 'example-module',
                'description' => 'An example module. This module just shows the user some HTML.',
                'active' => $logic->id,
                'visible' => $logic->id,
                'mandatory' => $logic->id,
                'completion_condition_instance_id' => $completionConditionInstance->id,
                'enabled' => true,
                'user_id' => $user->id,
                'order' => 1,
                'grouping_id' => $grouping->id
            ]);

            \BristolSU\Support\ModuleInstance\Settings\ModuleInstanceSetting::create([
                'key' => 'title',
                'value' => 'An example module',
                'module_instance_id' => $module->id,
                'encoded' => false
            ]);

            \BristolSU\Support\ModuleInstance\Settings\ModuleInstanceSetting::create([
                'key' => 'subtitle',
                'value' => 'Any HTML can be put below',
                'module_instance_id' => $module->id,
                'encoded' => false
            ]);

            \BristolSU\Support\ModuleInstance\Settings\ModuleInstanceSetting::create([
                'key' => 'html',
                'value' => '<p>This page can show any HTML you\'d like.</p><p>Head to the settings page to change what this says, or add more HTML.</p><p>You can click below to mark the module as complete, and go to the progress tracking page to see the effect of this.</p>',
                'module_instance_id' => $module->id,
                'encoded' => false
            ]);

            \BristolSU\Support\ModuleInstance\Settings\ModuleInstanceSetting::create([
                'key' => 'button_text',
                'value' => 'Click here to mark the module as complete.',
                'module_instance_id' => $module->id,
                'encoded' => false
            ]);

            \BristolSU\Support\Permissions\Models\ModuleInstancePermission::create([
                'logic_id' => $logic->id,
                'ability' => 'static-page.view-page',
                'module_instance_id' => $module->id
            ]);
            \BristolSU\Support\Permissions\Models\ModuleInstancePermission::create([
                'logic_id' => $logic->id,
                'ability' => 'static-page.click-button',
                'module_instance_id' => $module->id
            ]);
            \BristolSU\Support\Permissions\Models\ModuleInstancePermission::create([
                'logic_id' => $logic->id,
                'ability' => 'static-page.delete-button-click',
                'module_instance_id' => $module->id
            ]);
            \BristolSU\Support\Permissions\Models\ModuleInstancePermission::create([
                'logic_id' => $logic->id,
                'ability' => 'static-page.admin.view-page',
                'module_instance_id' => $module->id
            ]);
            \BristolSU\Support\Permissions\Models\ModuleInstancePermission::create([
                'logic_id' => $logic->id,
                'ability' => 'static-page.admin.page-view.index',
                'module_instance_id' => $module->id
            ]);
        }

    }
}
