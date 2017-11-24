<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderCertificateType extends Enum
{
    const QUALIFICATION = 1; //资质证书
    const PATENT = 2;//专利证书
    const HONOR = 3;//荣誉证书


    /**
     * ProviderCertificateType TYPE.
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
     * Acceptable project case count type.
     *
     * @var array
     */
    protected static $enums = [
        self::QUALIFICATION => '资质证书',
        self::PATENT        => '专利证书',
        self::HONOR         => '荣誉证书',
    ];
}