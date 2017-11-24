<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ValidMobileEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $mobile;
    /**
     * @var string
     */
    public $verifycode;
    /**
     * @var Carbon
     */
    public $expire;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'mobile'     => $this->mobile,
            'verifycode' => $this->verifycode,
            'expire'     => $this->expire->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}
