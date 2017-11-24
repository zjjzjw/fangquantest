<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserPermissionProjectCategoryType extends Enum
{
    const HOUSE = 1;
    const HOTEL = 2;
    const INDUSTRY = 3;
    const OFFICE = 4;
    const COMPLEX = 5;
    const OTHER = 6;


    /**
     * FqUserPermissionProjectCategoryType TYPE.
     *
     * @var int
     */
    public $status;

    /**
     * Define property name of enum value.
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::HOUSE    => '住宅',
        self::HOTEL    => '酒店',
        self::INDUSTRY => '工业',
        self::OFFICE   => '办公楼',
        self::COMPLEX  => '商业综合体',
        self::OTHER    => '其他',
    ];
}