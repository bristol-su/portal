<?php

namespace App\Support\UnionCloud;

use BristolSU\ControlDB\AdditionalProperties\AdditionalPropertyStore;
use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Traits\DataUserTrait;
use Carbon\Carbon;
use DateTime;
use Twigger\UnionCloud\API\Resource\User;

class DataUserModel implements DataUser
{
    use DataUserTrait;

    /**
     * @var User
     */
    public $user;

    private $properties = [];

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->id(),
            'first_name' => $this->firstName(),
            'last_name' => $this->lastName(),
            'preferred_name' => $this->preferredName(),
            'dob' => $this->dob(),
            'email' => $this->email()
        ];
    }

    /**
     * @inheritDoc
     */
    public function id(): int
    {
        return $this->user->uid;
    }

    /**
     * @inheritDoc
     */
    public function firstName(): ?string
    {
        return $this->user->forename;
    }

    /**
     * @inheritDoc
     */
    public function lastName(): ?string
    {
        return $this->user->surname;
    }

    /**
     * @inheritDoc
     */
    public function email(): ?string
    {
        return $this->user->email;
    }

    /**
     * @inheritDoc
     */
    public function dob(): ?DateTime
    {
        return Carbon::parse($this->user->dob);
    }

    /**
     * @inheritDoc
     */
    public function preferredName(): ?string
    {
        return $this->firstName() . ' ' . $this->lastName();
    }

    /**
     * @inheritDoc
     */
    public function setFirstName(?string $firstName): void
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    /**
     * @inheritDoc
     */
    public function setLastName(?string $lastName): void
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    /**
     * @inheritDoc
     */
    public function setEmail(?string $email): void
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    /**
     * @inheritDoc
     */
    public function setDob(?DateTime $dob): void
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    /**
     * @inheritDoc
     */
    public function setPreferredName(?string $name): void
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Add an additional property
     *
     * @param $key
     */
    public static function addProperty(string $key): void
    {
        app(AdditionalPropertyStore::class)->addProperty(static::class, $key);
    }

    /**
     * Get all additional attributes the model is using
     *
     * @return array
     */
    public static function getAdditionalAttributes(): array
    {
        return (app(AdditionalPropertyStore::class)->getProperties(static::class) ?? []);
    }

    /**
     * Retrieve an additional attribute value
     *
     * @param string $key Key of the attribute
     * @return mixed Value of the attribute
     */
    public function getAdditionalAttribute(string $key)
    {
        return optional($this->user)->{$key};
    }

    /**
     * Set an additional attribute value
     *
     * @param string $key Key of the attribute
     * @param mixed $value Value of the attribute
     */
    public function setAdditionalAttribute(string $key, $value)
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    /**
     * Save an additional attribute value
     *
     * @param string $key Key of the attribute
     * @param mixed $value Value of the attribute
     */
    public function saveAdditionalAttribute(string $key, $value)
    {
        throw new \Exception('Cannot edit a UnionCloud Data User');
    }

    public static function fromUnionCloudUser(User $unionCloudUser)
    {
        $user = new static;
        $user->user = $unionCloudUser;
        return $user;
    }

    public function __toString()
    {
        return $this->toJson();
    }
}