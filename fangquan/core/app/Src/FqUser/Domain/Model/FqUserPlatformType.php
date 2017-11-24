<?php

namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserPlatformType extends Enum
{
    const  TYPE_PC = 1; //PC网站自注册
    const  TYPE_ANDROID = 2; //安卓客户端
    const  TYPE_IOS = 4; //IOS客户端
    const  TYPE_ADMIN = 3; //Admin后台创建
    const  TYPE_WECHAT_PUBLIC = 5;//微信公众号扫码


    /**
     * FqUserPlatformType TYPE.
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
        self::TYPE_PC            => 'PC',
        self::TYPE_ANDROID       => 'Android',
        self::TYPE_IOS           => 'IOS',
        self::TYPE_ADMIN         => 'Admin',
        self::TYPE_WECHAT_PUBLIC => 'WechatPublic',
    ];
}