<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 有无电梯
 * Class DeveloperProjectElevatorType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectElevatorType extends Enum
{
    const YES = 1;//有
    const NO = 2;//无
    const UNKNOWN = 3;//未知


    /**
     * DeveloperProjectElevatorType type.
     *
     * @var int
     */
    public $type;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'type';

    /**
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::YES     => '有',
        self::NO      => '无',
        self::UNKNOWN => '未知',
    ];
}