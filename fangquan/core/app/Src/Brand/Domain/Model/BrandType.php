<?php namespace App\Src\Brand\Domain\Model;

use App\Foundation\Domain\Enum;

class BrandType extends Enum
{

    const DOMESTIC = 1;
    const IMPORTED = 2;
    const JOINT_VENTURE = 3;

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
        self::DOMESTIC      => '国产',
        self::IMPORTED      => '进口',
        self::JOINT_VENTURE => '合资',
    ];

}