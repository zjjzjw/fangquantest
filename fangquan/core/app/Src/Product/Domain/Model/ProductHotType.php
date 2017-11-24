<?php namespace App\Src\Product\Domain\Model;

use App\Foundation\Domain\Enum;

class ProductHotType extends Enum
{

    const NEWS = 1;
    const EXPLOSION = 2;

    /**
     * MsgStatus status.
     *
     * @var string
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::NEWS           => '新品',
        self::EXPLOSION      => '爆款',
    ];


}