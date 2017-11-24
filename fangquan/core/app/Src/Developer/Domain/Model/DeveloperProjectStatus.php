<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 项目上架状态
 * Class DeveloperProjectStatus
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectStatus extends Enum
{
    const YES = 1;//正常
    const NO = 2;//已下架


    /**
     * OperationModelType status.
     *
     * @var int
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::YES => '正常',
        self::NO  => '已下架',
    ];
}