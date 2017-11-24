<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class MobileRegisterEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $mobile;
    /**
     * @var string
     */
    public $verifycode;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $reg_id;


    public function __construct()
    {
    }

}
