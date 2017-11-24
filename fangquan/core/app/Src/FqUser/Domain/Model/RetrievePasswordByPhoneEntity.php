<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class RetrievePasswordByPhoneEntity extends Entity
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
    public $verifycode;

    /**
     * @var string
     */
    public $password;

    public function __construct()
    {
    }

}
