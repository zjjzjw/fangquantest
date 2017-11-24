<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 开发商类型
 * Class DeveloperProjectType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperType extends Enum
{
    const TOP_HUNDRED = 1;//百强开发商
    const NORMAL = 2;//普通开发商


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
        self::TOP_HUNDRED => '百强',
        self::NORMAL      => '普通',
    ];
}