<?php namespace App\Src\FqUser\Domain\Model;


use App\Foundation\Domain\Enum;

class MobileRegStatus extends Enum
{
    const NO_REG = 1;
    const YES_REG = 2;


    /**
     * MobileRegStatus TYPE.
     *
     * @var int
     */
    public $status;

    /**
     * Define property name of enum value.
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::NO_REG  => '不开启推送',
        self::YES_REG => '开启推送',
    ];
}