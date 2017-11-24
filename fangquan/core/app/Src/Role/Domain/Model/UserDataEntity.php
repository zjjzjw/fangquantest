<?php
namespace App\Src\Role\Domain\Model;

use App\Foundation\Domain\Entity;

class UserDataEntity extends Entity
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
    public $data_id;
    /**
     * @var int
     */
    public $data_type;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'data_id'   => $this->data_id,
            'data_type' => $this->data_type,
        ];
    }

}