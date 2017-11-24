<?php namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\Enum;

class BrandCompanyType extends Enum
{

    const GYQY = 1;
    const JTSYZ = 2;
    const SYQY = 3;
    const GFZQY = 4;
    const LYQY = 5;
    const WSTZ = 6;
    const GATQY = 7;
    const GFHZQY = 8;

    /**
     * MsgStatus status.
     *
     * @var string
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [
        self::GYQY => '国有企业',
        self::JTSYZ  => '集团所有制企业',
        self::SYQY  => '私营企业',
        self::GFZQY  => '股份制企业',
        self::LYQY  => '联营企业',
        self::WSTZ  => '外商投资企业',
        self::GATQY  => '港澳台企业',
        self::GFHZQY  => '股份合作企业',
    ];


}