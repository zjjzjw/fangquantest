<?php

namespace App\Src\Role\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 用户是否启用
 * Class UserStatus
 * @package App\Src\Role\Domain\Model
 */
class UserType extends Enum
{
    const ADMIN = 1;//后台登录用户
    const CUSTOMER = 2;//客户


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
        self::ADMIN    => '后台登录用户',
        self::CUSTOMER => '客户',
    ];
}