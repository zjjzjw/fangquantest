<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderImageType extends Enum
{
    const LOGO = 1;
    const LICENSE = 2;
    const STRUCTURE = 3;
    const SUB_STRUCTURE = 4;
    const FACTORY = 5;
    const DEVICE = 6;


    /**
     * loan type.
     *
     * @var string
     */
    public $type;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'type';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::LOGO          => 'logo图片',
        self::LICENSE       => '营业执照照片',
        self::STRUCTURE     => '总公司部门架构图',
        self::SUB_STRUCTURE => '分支机构架构图',
        self::FACTORY       => '工厂照片',
        self::DEVICE        => '设备照片',
    ];


}