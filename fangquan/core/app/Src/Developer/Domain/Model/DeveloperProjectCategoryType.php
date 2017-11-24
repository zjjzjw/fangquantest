<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 项目类别
 * Class DeveloperProjectType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectCategoryType extends Enum
{
    const ZZ = 1;//住宅
    const JD = 2;//酒店
    const GY = 3;//工业
    const BGL = 4;//写字楼
    const SYZH = 5;//商业综合体
    const GYSZ = 6;//公寓(商住)
    const YLDT = 7;//养老地产
    const TEXZ = 8;//特色小镇
    const CYYQ = 9;//产业园区
    const SY = 10; //商用
    const QT = 11;//其他

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
        self::ZZ   => '住宅',
        self::JD   => '酒店',
        self::GY   => '工业',
        self::BGL  => '写字楼',
        self::SYZH => '商业综合体',
        self::GYSZ => '公寓(商住)',
        self::YLDT => '养老地产',
        self::TEXZ => '特色小镇',
        self::CYYQ => '产业园区',
        self::SY   => '商用',
        self::QT   => '其他',
    ];
}