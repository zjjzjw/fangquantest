<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 是否广告
 * Class DeveloperProjectAdType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectAdType extends Enum
{
    const YES = 1;//是
    const NO = 2;//否


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
        self::YES   => '是',
        self::NO   => '否',
    ];
}