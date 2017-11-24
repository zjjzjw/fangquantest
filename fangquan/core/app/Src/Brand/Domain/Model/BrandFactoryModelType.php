<?php namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\Enum;

class BrandFactoryModelType extends Enum
{

    const CJZY = 1;
    const JXS = 2;
    const QT = 3;

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
        self::CJZY => '厂家代理',
        self::JXS  => '经销商/代理商',
        self::QT  => '其他',
    ];

}