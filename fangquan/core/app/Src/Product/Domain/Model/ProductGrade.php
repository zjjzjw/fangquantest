<?php namespace App\Src\Product\Domain\Model;

use App\Foundation\Domain\Enum;

class ProductGrade extends Enum
{

    const SUPER = 1;
    const HIGH = 2;
    const MEDIUM = 3;
    const IN = 4;
    const LOW_MEDIUM = 5;
    const LOW = 6;

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
        self::SUPER      => '超高档',
        self::HIGH       => '高档',
        self::MEDIUM     => '中高档',
        self::IN         => '中档',
        self::LOW_MEDIUM => '中低档',
        self::LOW        => '低档',
    ];


}