<?php

namespace App\Src\FqUser\Domain\Model;


use App\Foundation\Domain\Enum;

class FqUserRegisterType extends Enum
{
    const  PHONE = 1; // 手机
    const  EMAIL = 2; // 邮箱
    const  WECHAT = 3; // 微信开放平台
    const  WEIBO = 4; // 微博
    const  QQ = 5; // QQ
    const  ACCOUNT = 6; // 用户名
    const  WECHAT_PUBLIC = 7;//微信公众号

    /**
     * FqUserRegisterType TYPE.
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
        self::PHONE         => '手机',
        self::EMAIL         => '邮箱',
        self::WECHAT        => '微信',
        self::WEIBO         => '微博',
        self::QQ            => 'QQ',
        self::ACCOUNT       => '用户名',
        self::WECHAT_PUBLIC => '微信公众号',
    ];
}