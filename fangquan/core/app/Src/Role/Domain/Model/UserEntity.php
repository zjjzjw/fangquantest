<?php

namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\Entity;

class UserEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $account;

    /**
     * @var string
     */
    public $company_id;

    /**
     * @var string
     */
    public $company_name;

    /**
     * @var string
     */
    public $employee_id;

    /**
     * @var string
     */
    public $position;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $password;

    /**
     * 权限只做到角色
     * @var array
     */
    public $role_ids;

    /**
     * @var array
     */
    public $roles;

    /**
     *
     * @var array
     */
    public $depart_ids;

    /**
     * @var array
     */
    public $departs;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $type;

    /**
     * @var string
     */
    public $remember_token;

    /**
     * @var int
     */
    public $created_user_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'              => $this->id,
            'account'         => $this->account,
            'company_id'      => $this->company_id,
            'company_name'    => $this->company_name,
            'employee_id'     => $this->employee_id,
            'position'        => $this->position,
            'name'            => $this->name,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'roles'           => $this->roles,
            'departs'         => $this->departs,
            'role_ids'        => $this->role_ids,
            'depart_ids'      => $this->depart_ids,
            'status'          => $this->status,
            'type'            => $this->type,
            'remember_token'  => $this->remember_token,
            'created_user_id' => $this->created_user_id,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }

}