<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 认证信息
 * Class DeveloperStatus
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperStatus extends Enum
{
    const YES = 1;//已认证
    const NO = 2;//未认证
    const OFF = 3;//下架


    /**
     * DeveloperStatus status.
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
        self::YES => '已认证',
        self::NO  => '未认证',
        self::OFF => '下架',
    ];
}