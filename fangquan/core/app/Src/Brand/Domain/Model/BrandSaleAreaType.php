<?php namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\Enum;

class BrandSaleAreaType extends Enum
{

    const HB = 1;
    const HN = 2;
    const HZ = 3;
    const HZH = 4;
    const DB = 5;
    const XB = 6;
    const XN = 7;
    const GAT = 8;

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
        self::HB  => '华北',
        self::HN  => '华南',
        self::HZ  => '华东',
        self::HZH => '华中',
        self::DB  => '东北',
        self::XB  => '西北',
        self::XN  => '西南',
        self::GAT => '港澳台地区',
    ];

}