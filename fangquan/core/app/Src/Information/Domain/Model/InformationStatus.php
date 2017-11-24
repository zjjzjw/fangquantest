<?php namespace App\Src\Information\Domain\Model;

use App\Foundation\Domain\Enum;

class InformationStatus extends Enum
{

    const YES = 1;
    const NO = 2;

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
        self::YES    => '是',
        self::NO     => '否',
    ];


}