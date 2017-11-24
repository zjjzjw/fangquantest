<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 联系人类型
 * Class DeveloperProjectContactType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectContactType extends Enum
{
    const KFS = 1;//开发商
    const JZDW = 2;//建筑单位
    const SJY = 3;//设计院
    const QT = 4;//其他


    /**
     * DeveloperProjectContactType type.
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
        self::KFS  => '开发商',
        self::JZDW => '建筑单位',
        self::SJY  => '设计院',
        self::QT   => '其他',
    ];
}