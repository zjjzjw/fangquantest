<?php namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\Enum;

class BrandCertificateType extends Enum
{

    const QZRZ = 1;
    const GLTX = 2;
    const HJRZ = 3;
    const OTHER = 4;

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
        self::QZRZ  => '强制认证证书',
        self::GLTX  => '管理体系认证证书',
        self::HJRZ  => '环境标志认证证书',
        self::OTHER => '其他',
    ];

}