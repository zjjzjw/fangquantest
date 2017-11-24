<?php

namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserAccountStatus extends Enum
{
    const  TYPE_EMAIL = 1; //邮箱账号
    const  TYPE_MOBILE = 2; //手机账号
    const  TYPE_ADMIN = 3; //admin后台账号


    /**
     * FqUserProjectStatus TYPE.
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
     * Acceptable operation  model Type.
     *
     * @var array
     */
    protected static $enums = [
        self::TYPE_EMAIL  => '邮箱账号',
        self::TYPE_MOBILE => '手机账号',
        self::TYPE_ADMIN  => 'admin后台账号',
    ];
}