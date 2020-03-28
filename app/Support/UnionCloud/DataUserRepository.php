<?php

namespace App\Support\UnionCloud;

use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use Twigger\UnionCloud\API\UnionCloud;

class DataUserRepository implements DataUser
{

    /**
     * @var UnionCloud
     */
    private $unionCloud;

    public function __construct(UnionCloud $unionCloud)
    {
        $this->unionCloud = $unionCloud;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        $user = $this->unionCloud->users()->setMode('standard')->getByUID($id)->get()->first();
        return DataUserModel::fromUnionCloudUser($user);
    }

    /**
     * @inheritDoc
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        if(isset($attributes['first_name'])) {
            $attributes['forename'] = $attributes['first_name'];
            unset($attributes['first_name']);
        }
        if(isset($attributes['last_name'])) {
            $attributes['surname'] = $attributes['last_name'];
            unset($attributes['last_name']);
        }
        $user = $this->unionCloud->users()->setMode('standard')->search($attributes)->get()->first();
        return DataUserModel::fromUnionCloudUser($user);
    }

    /**
     * @inheritDoc
     */
    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?\DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        throw new \Exception('UnionCloud does not allow user creation');
    }
}
