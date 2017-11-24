<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class FqUserEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $nickname;
    /**
     * @var string
     */
    public $mobile;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $account;
    /**
     * @var integer
     */
    public $account_type;
    /**
     * @var integer
     */
    public $role_type;
    /**
     * @var integer
     */
    public $role_id;
    /**
     * @var integer
     */
    public $platform_id;
    /**
     * @var integer
     */
    public $register_type_id;
    /**
     * @var integer
     */
    public $avatar;
    /**
     * @var string
     */
    public $project_area;
    /**
     * @var string
     */
    public $project_category;
    /**
     * @var integer
     */
    public $admin_id;
    /**
     * @var string
     */
    public $reg_time;
    /**
     * @var string
     */
    public $expire;
    /**
     * @var string
     */
    public $password;
    /**
     * @var integer
     */
    public $status;
    /**
     * @var string
     */
    public $company_name;
    /**
     * @var int
     */
    public $salt;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'               => $this->id,
            'nickname'         => $this->nickname,
            'mobile'           => $this->mobile,
            'email'            => $this->email,
            'account'          => $this->account,
            'account_type'     => $this->account_type,
            'role_type'        => $this->role_type,
            'role_id'          => $this->role_id,
            'platform_id'      => $this->platform_id,
            'register_type_id' => $this->register_type_id,
            'avatar'           => $this->avatar,
            'project_area'     => $this->project_area,
            'project_category' => $this->project_category,
            'admin_id'         => $this->admin_id,
            'reg_time'         => $this->reg_time,
            'expire'           => $this->expire,
            'password'         => $this->password,
            'status'           => $this->status,
            'salt'             => $this->salt,
            'company_name'     => $this->company_name,
            'created_at'       => $this->created_at->toDateTimeString(),
            'updated_at'       => $this->updated_at->toDateTimeString(),
        ];
    }

}
