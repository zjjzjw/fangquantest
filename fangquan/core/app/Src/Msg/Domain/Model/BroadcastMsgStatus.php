<?php namespace App\Src\Msg\Domain\Model;

use App\Foundation\Domain\Enum;

class BroadcastMsgStatus extends Enum
{

    const HAS_DEAL = 1;
    const NOT_DEAL = 2;

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
        self::HAS_DEAL => '已处理',
        self::NOT_DEAL => '未处理',
    ];


}