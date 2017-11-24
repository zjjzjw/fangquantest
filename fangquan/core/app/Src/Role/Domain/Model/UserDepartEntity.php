<?php

namespace App\Src\Role\Domain\Model;

use App\Foundation\Domain\Entity;
use App\Src\Role\Infra\Eloquent\UserModel;

class UserDepartEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';
    /**
     * @var int
     */
    public $user_id;
    /**
     * @var int
     */
    public $depart_id;

    /**
     * @var UserModel
     */
    public $user;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'depart_id' => $this->depart_id,
            'user'      => $this->user,
        ];
    }

}