<?php

namespace App\Support\Auth;

use App\Support\Settings\SettingRepository;
use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use BristolSU\Support\User\Contracts\UserRepository;
use BristolSU\Support\User\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserProvider implements \Illuminate\Contracts\Auth\UserProvider
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     * @return User|null
     */
    public function retrieveById($identifier)
    {
        try {
            return $this->userRepository->getById($identifier);
        } catch (ModelNotFoundException $e) {}
        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed $identifier
     * @param string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        try {
            $user = $this->userRepository->getFromRememberToken($token);
            if($user->id === $identifier) {
                return $user;
            }
        } catch (ModelNotFoundException $e) {}
        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param Authenticatable|User $user
     * @param string $token
     * @return User|Authenticatable|null
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $this->userRepository->setRememberToken($user->id, $token);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (!array_key_exists('identifier', $credentials)) {
            return null;
        }

        try {
            $dataUser = app(DataUser::class)->getWhere([
                siteSetting('authentication.registration_identifier.identifier', 'email') => $credentials['identifier']
            ]);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        try {
            $controlUser = app(\BristolSU\ControlDB\Contracts\Repositories\User::class)->getByDataProviderId($dataUser->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }

        try {
            $user = $this->userRepository->getFromControlId($controlUser->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }

        return $user;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if(app(Hasher::class)->check($credentials['password'], $user->password)) {
            return true;
        }
        return false;
    }
}
