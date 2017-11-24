<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Enum;

class ProviderManagementType extends Enum
{

    const DEVELOPER = 1;
    const PROVIDER = 2;
    const UNKNOWN = 3;

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
        self::DEVELOPER => '厂家直营',
        self::PROVIDER  => '经销商/代理商',
        self::UNKNOWN   => '其他',
    ];


}