<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class ThirdPartyRegisterEntity extends Entity
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
    public $nickname;

    /**
     * @var int
     */
    public $avatar;

    /**
     * @var string
     */
    public $reg_id;

    /**
     * @var string
     */
    public $device_type;


    public function __construct()
    {
    }

}
