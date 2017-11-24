<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 项目阶段
 * Class DeveloperProjectStageType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectStageType extends Enum
{
    const CONCEIVE = 1; // 构思
    const DESIGN = 2; // 设计
    const DRAFT = 3; // 文章草议
    const INVITATION = 4; // 施工单位招标
    const CLOSING = 5; // 截标后
    const START = 6; // 主体工程中标/开工
    const DECORATE = 7; // 室内装修/封顶后分包工程
    const UNKNOW = 8; // 未知

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
        self::CONCEIVE   => '构思',
        self::DESIGN     => '设计',
        self::DRAFT      => '文章草议',
        self::INVITATION => '施工单位招标',
        self::CLOSING    => '截标后',
        self::START      => '主体工程中标/开工',
        self::DECORATE   => '室内装修/封顶后分包工程',
        self::UNKNOW     => '未知',
    ];


    protected static $colour_enums = [
        self::CONCEIVE   => 'ff8c77',
        self::DESIGN     => '84bc7f',
        self::DRAFT      => '7c98bd',
        self::INVITATION => '22c5ca',
        self::CLOSING    => 'ffac5c',
        self::START      => '84bc7f',
        self::DECORATE   => '7c98bd',
    ];

    public static function acceptableAppColourEnums()
    {
        return static::$colour_enums;
    }
}