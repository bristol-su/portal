<?php

namespace App\Rules\Authentication;

use BristolSU\Support\User\Contracts\UserAuthentication;
use BristolSU\Support\User\User;
use Illuminate\Contracts\Validation\Rule;

class RoleIdIsOwned implements Rule
{

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        /** @var User $user */
        $user = app(UserAuthentication::class)->getUser();
        if($user === null) {
            return false;
        }
        return in_array((int) $value, $user->controlUser()->roles()->pluck('id')->toArray());
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'The current user must be in the given role';
    }
}
