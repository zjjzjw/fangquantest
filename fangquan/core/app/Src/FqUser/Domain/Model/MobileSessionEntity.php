<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class MobileSessionEntity extends Entity
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
    public $token;
    /**
     * @var string
     */
    public $reg_id;
    /**
     * @var int
     */
    public $type;
    /**
     * @var int
     */
    public $enable_notify;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'token'         => $this->token,
            'reg_id'        => $this->reg_id,
            'type'          => $this->type,
            'enable_notify' => $this->enable_notify,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }

}
