<?php namespace App\Src\FqUser\Domain\Model;


use App\Foundation\Domain\Enum;

class FqUserStatus extends Enum
{
    const NORMAL_USE = 1;
    const DISABLE = 2;
    const NO_ACTIVE = 3;


    /**
     * FqUserStatus TYPE.
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
        self::NORMAL_USE => '正常使用',
        self::DISABLE    => '禁用',
        self::NO_ACTIVE  => '未激活',
    ];
}