<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 项目类型
 * Class DeveloperProjectType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectType extends Enum
{
    const XJ = 1;//新建
    const FX = 2;//翻新
    const KJ = 3;//扩建
    const SNZX = 4;//室内装修
    const SBAZ = 5;//设备安装


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
        self::XJ   => '新建',
        self::FX   => '翻新',
        self::KJ   => '扩建',
        self::SNZX => '室内装修',
        self::SBAZ => '设备安装',
    ];
}