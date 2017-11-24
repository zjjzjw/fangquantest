<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class BindPhoneEntity extends Entity
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

    public function __construct()
    {
    }

}
