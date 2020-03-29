<?php

namespace App\Support\UnionCloud;

use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;
use Twigger\UnionCloud\API\Resource\User;
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
        if(Cache::has('unioncloud-data-user-get-by-id:' . $id)) {
            return Cache::get('unioncloud-data-user-get-by-id:' . $id);
        }

        try {
            $user = $this->unionCloud->users()->setMode('standard')->getByUID($id)->get()->first();
        } catch (BaseUnionCloudException $exception) {
            $user = new User(['uid' => $id]);
        }

        $dataUser = DataUserModel::fromUnionCloudUser($user);
        Cache::forever('unioncloud-data-user-get-by-id:' . $id, $dataUser);

        return $dataUser;
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
        try {
            $user = $this->unionCloud->users()->setMode('standard')->search($attributes)->get()->first();
        } catch (\Exception $e) {
            throw new ModelNotFoundException();
        }
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
