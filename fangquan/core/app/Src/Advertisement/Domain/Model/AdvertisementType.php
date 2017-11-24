<?php

namespace App\Src\Advertisement\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 广告类型
 * Class AdvertisementStatus
 * @package App\Src\Advertisement\Domain\Model
 */
class AdvertisementType extends Enum
{
    const PROVIDER = 1;// 供应商广告
    const DEVELOPER_PROJECT = 2;// 开发商项目广告


    /**
     * DeveloperStatus status.
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
        self::PROVIDER          => '供应商广告',
        self::DEVELOPER_PROJECT => '开发商项目广告',
    ];
}