<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 是否优选
 * Class DeveloperProjectGreatType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectGreatType extends Enum
{
    const YES = 1;//优质
    const NO = 2;//普通


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
        self::YES => '优质',
        self::NO  => '普通',
    ];
}