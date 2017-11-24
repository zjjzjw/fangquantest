<?php namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class UserInfoEntity extends Entity
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
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $position;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $email;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'name'       => $this->name,
            'company'    => $this->company,
            'phone'      => $this->phone,
            'position'   => $this->position,
            'email'      => $this->email,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}