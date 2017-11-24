<?php namespace App\Src\Msg\Domain\Model;

use App\Foundation\Domain\Enum;

class MsgStatus extends Enum
{

    const HAS_READ = 1;
    const NOT_READ = 2;

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
        self::HAS_READ => '已读',
        self::NOT_READ => '未读',
    ];


}