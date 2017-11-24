<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 数据来源
 * Class DeveloperProjectType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectSourceType extends Enum
{
    const RCC = 1;//RCC瑞达恒
    const TC = 2;//天辰
    const ZBCG = 3;//中国招标与采购网
    const MNZJ = 4;//中国拟在建项目网
    const QLMYZ = 5;//千里马-优质
    const QLMPT = 6;//千里马-普通
    const DFYH = 7;//东方雨虹
    const MYY = 8;//明源云采购网
    const SY = 9;//私有


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
        self::RCC   => 'RCC瑞达恒',
        self::TC   => '天辰',
        self::ZBCG   => '中国招标与采购网',
        self::MNZJ  => '中国拟在建项目网',
        self::QLMYZ => '千里马-优质',
        self::QLMPT   => '千里马-普通',
        self::DFYH   => '东方雨虹',
        self::MYY   => '明源云采购网',
        self::SY   => '私有',
    ];
}