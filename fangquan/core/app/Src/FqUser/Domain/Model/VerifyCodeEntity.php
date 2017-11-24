<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class VerifyCodeEntity extends Entity
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
     * @var int
     */
    public $type;


    public function __construct()
    {
    }

}
