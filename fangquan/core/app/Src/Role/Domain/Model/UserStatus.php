<?php

namespace App\Src\Role\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 用户是否启用
 * Class UserStatus
 * @package App\Src\Role\Domain\Model
 */
class UserStatus extends Enum
{
    const YES = 1;//启用
    const NO = 2;//禁用


    /**
     * UserStatus status.
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
        self::YES => '启用',
        self::NO  => '禁用',
    ];
}