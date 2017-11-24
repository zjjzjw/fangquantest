<?php

namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\Entity;

class RoleEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';


    /**
     * @var Carbon
     */
    public $name;

    /**
     * @var int
     */
    public $desc;

    /**
     * @var array
     */
    public $permissions;

    /**
     * @var array
     */
    public $users;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'desc'        => $this->desc,
            'permissions' => $this->permissions,
            'users'       => $this->users,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }

}