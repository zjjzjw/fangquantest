<?php

namespace App\Src\Role\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 用户搜索项
 * Class UserSearch
 * @package App\Src\Role\Domain\Model
 */
class UserSearchType extends Enum
{
    const EMPLOYEE_ID = 1;//工号
    const WEI_USER_ID = 2;//微信号
    const NAME = 3;//姓名
    const PHONE = 4;//手机号
    const EMAIL = 5;//电子邮箱


    /**
     * UserSearchType status.
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
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::EMPLOYEE_ID => '工号',
        self::WEI_USER_ID => '微信号',
        self::NAME        => '姓名',
        self::PHONE       => '手机号',
        self::EMAIL       => '电子邮箱',
    ];

    protected static $enum_columns = [
        self::EMPLOYEE_ID => 'employee_id',
        self::WEI_USER_ID => 'wx_user_id',
        self::NAME        => 'name',
        self::PHONE       => 'phone',
        self::EMAIL       => 'email',
    ];

    public static function acceptableEnumColumns()
    {
        return static::$enum_columns;
    }
}