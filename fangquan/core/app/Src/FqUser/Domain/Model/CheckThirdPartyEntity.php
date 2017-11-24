<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class CheckThirdPartyEntity extends Entity
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
     * @var string
     */
    public $open_id;
    /**
     * @var string
     */
    public $reg_id;


    public function __construct()
    {
    }

}
