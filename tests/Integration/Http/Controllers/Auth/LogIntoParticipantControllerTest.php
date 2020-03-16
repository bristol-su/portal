<?php

namespace Tests\Integration\Http\Controllers\Auth;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Support\Activity\Activity;
use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\User\User;
use Tests\TestCase;

class LogIntoParticipantControllerTest extends TestCase
{

    /** @test */
    public function it_returns_an_error_if_the_incorrect_user_id_is_passed(){
        $activity = factory(Activity::class)->create();

        $realUser = factory(\BristolSU\ControlDB\Models\User::class)->create();
        $attemptedUser = factory(\BristolSU\ControlDB\Models\User::class)->create();

        $databaseUser = factory(User::class)->create(['control_id' => $realUser->id]);
        app(UserAuthentication::class)->setUser($databaseUser);

        $response = $this->post('/login/participant/' . $activity->slug, [
            'login_id' => $attemptedUser->id,
            'login_type' => 'user'
        ]);

        $response->assertSessionHasErrors(['login_id' => 'The user must be owned by the current user']);
    }

    /** @test */
    public function it_does_not_return_an_error_if_the_correct_user_id_is_passed(){
        $activity = factory(Activity::class)->create();

        $realUser = factory(\BristolSU\ControlDB\Models\User::class)->create();

        $databaseUser = factory(User::class)->create(['control_id' => $realUser->id]);
        app(UserAuthentication::class)->setUser($databaseUser);

        $response = $this->post('/login/participant/' . $activity->slug, [
            'login_id' => $realUser->id,
            'login_type' => 'user'
        ]);

        $response->assertSessionHasNoErrors();
    }



    /** @test */
    public function it_returns_an_error_if_a_not_owned_group_id_is_passed(){
        $activity = factory(Activity::class)->create();

        $user = factory(\BristolSU\ControlDB\Models\User::class)->create();
        $realGroup = factory(Group::class)->create();
        $attemptedGroup = factory(Group::class)->create();
        app(UserGroup::class)->addUserToGroup($user, $realGroup);

        $databaseUser = factory(User::class)->create(['control_id' => $user->id]);
        app(UserAuthentication::class)->setUser($databaseUser);

        $response = $this->post('/login/participant/' . $activity->slug, [
            'login_id' => $attemptedGroup->id,
            'login_type' => 'group'
        ]);

        $response->assertSessionHasErrors(['login_id' => 'The current user must have a membership to the group']);
    }

    /** @test */
    public function it_does_not_return_an_error_if_an_owned_group_id_is_passed(){
        $activity = factory(Activity::class)->create();

        $user = factory(\BristolSU\ControlDB\Models\User::class)->create();
        $realGroup = factory(Group::class)->create();
        app(UserGroup::class)->addUserToGroup($user, $realGroup);

        $databaseUser = factory(User::class)->create(['control_id' => $user->id]);
        app(UserAuthentication::class)->setUser($databaseUser);

        $response = $this->post('/login/participant/' . $activity->slug, [
            'login_id' => $realGroup->id,
            'login_type' => 'group'
        ]);

        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function it_returns_an_error_if_a_not_owned_role_id_is_passed(){
        $activity = factory(Activity::class)->create();

        $user = factory(\BristolSU\ControlDB\Models\User::class)->create();
        $realRole = factory(Role::class)->create();
        $attemptedRole = factory(Role::class)->create();
        app(UserRole::class)->addUserToRole($user, $realRole);

        $databaseUser = factory(User::class)->create(['control_id' => $user->id]);
        app(UserAuthentication::class)->setUser($databaseUser);

        $response = $this->post('/login/participant/' . $activity->slug, [
            'login_id' => $attemptedRole->id,
            'login_type' => 'role'
        ]);

        $response->assertSessionHasErrors(['login_id' => 'The current user must be in the given role']);
    }

    /** @test */
    public function it_does_not_return_an_error_if_an_owned_role_id_is_passed(){
        $activity = factory(Activity::class)->create();

        $user = factory(\BristolSU\ControlDB\Models\User::class)->create();
        $realRole = factory(Role::class)->create();
        app(UserRole::class)->addUserToRole($user, $realRole);

        $databaseUser = factory(User::class)->create(['control_id' => $user->id]);
        app(UserAuthentication::class)->setUser($databaseUser);

        $response = $this->post('/login/participant/' . $activity->slug, [
            'login_id' => $realRole->id,
            'login_type' => 'role'
        ]);

        $response->assertSessionHasNoErrors();
    }

}
