<?php

namespace App\Src\Advertisement\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 认证信息
 * Class AdvertisementStatus
 * @package App\Src\Advertisement\Domain\Model
 */
class AdvertisementStatus extends Enum
{
    const YES = 1;//显示
    const NO = 2;//隐藏


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
        self::YES => '显示',
        self::NO  => '隐藏',
    ];
}