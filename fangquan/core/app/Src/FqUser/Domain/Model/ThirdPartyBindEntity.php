<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class ThirdPartyBindEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $third_type;
    /**
     * @var int
     */
    public $open_id;

    /**
     * @var int
     */
    public $user_id;


    public function __construct()
    {
    }

}
