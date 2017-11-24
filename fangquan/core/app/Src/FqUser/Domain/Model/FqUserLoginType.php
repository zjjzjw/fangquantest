<?php

namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserLoginType extends Enum
{
    const  TYPE_PC = 1; //PC网站自注册
    const  TYPE_APP = 2; //APP客户端


    /**
     * FqUserLoginType TYPE.
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
        self::TYPE_PC  => 'PC',
        self::TYPE_APP => 'APP',
    ];
}