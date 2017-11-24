<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;


/**
 * 验证码类型
 *
 * Class VerifycodeTypeEnums
 */
class VerifyCodeType extends Enum
{
    const REGISTER = 1;//注册
    const RETRIEVE_PWD = 2;//找回密码
    const BIND_PHONE = 3;//绑定手机号

    /**
     * VerifycodeType TYPE.
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
     * Acceptable verifycode type.
     *
     * @var array
     */
    protected static $enums = [
        self::REGISTER     => '注册',
        self::RETRIEVE_PWD => '找回密码',
        self::BIND_PHONE   => '绑定手机号',
    ];
}