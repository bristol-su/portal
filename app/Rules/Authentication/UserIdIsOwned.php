<?php

namespace App\Rules\Authentication;

use BristolSU\Support\User\Contracts\UserAuthentication;
use Illuminate\Contracts\Validation\Rule;

class UserIdIsOwned implements Rule
{

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $user = app(UserAuthentication::class)->getUser();
        if($user === null) {
            return false;
        }
        return (int) $user->controlId() === (int) $value;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return 'The user must be owned by the current user';
    }
}
