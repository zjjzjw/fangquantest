<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 设计阶段
 * Class DeveloperProjectDecorate
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectDecorateType extends Enum
{
    const YES = 1;//是
    const NO = 2;//否
    const UNKNOWN = 3;//未知


    /**
     * OperationModelType type.
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
        self::YES     => '是',
        self::NO      => '否',
        self::UNKNOWN => '未知',
    ];
}