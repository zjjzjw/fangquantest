<?php namespace App\Src\Msg\Domain\Model;


use App\Foundation\Domain\Enum;

class MsgType extends Enum
{

    const SYSTEM = 1;

    /**
     * loan type.
     *
     * @var string
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
        self::SYSTEM => '系统消息',
    ];


}