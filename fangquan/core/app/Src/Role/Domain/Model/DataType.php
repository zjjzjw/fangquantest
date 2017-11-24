<?php namespace App\Src\Role\Domain\Model;


use App\Foundation\Domain\Enum;

class DataType extends Enum
{
    const TYPE_USER = 1;
    const TYPE_DEPART = 2;

    /**
     * loan type.
     *
     * @var string
     */
    public $type;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'type';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::TYPE_USER   => '用户',
        self::TYPE_DEPART => '部门',
    ];


}