<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class ConfigEntity extends Entity
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
    public $enable_notify;


    public function __construct()
    {
    }

}
