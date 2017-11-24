<?php namespace App\Src\FqUser\Domain\Model;

namespace App\Src\FqUser\Domain\Model;


use App\Foundation\Domain\Enum;

class FqUserRoleType extends Enum
{

    const UNKNOWN = 1;
    const PROVIDER = 2;
    const DEVELOPER = 3;
    const ADMIN = 4;

    /**
     * FqUserRoleType TYPE.
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
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [

        self::UNKNOWN   => '未知',
        self::PROVIDER  => '供应商',
        self::DEVELOPER => '开发商',
        self::ADMIN     => '后台账号',
    ];


}