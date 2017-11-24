<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class MobileLoginEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $account;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $reg_id;

    /**
     * @var string
     */
    public $ip;


    public function __construct()
    {
    }

}
