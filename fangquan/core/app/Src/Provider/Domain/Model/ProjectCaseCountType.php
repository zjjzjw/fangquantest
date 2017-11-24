<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;


class ProjectCaseCountType extends Enum
{
    const ALL = 0;
    const STEP_ONT_TYPE = 1;
    const STEP_TWO_TYPE = 2;
    const STEP_THREE_TYPE = 3;


    /**
     * ProjectCaseCountType TYPE.
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
     * Acceptable project case count type.
     *
     * @var array
     */
    protected static $enums = [
        self::ALL             => '不限',
        self::STEP_ONT_TYPE   => '1个及以上',
        self::STEP_TWO_TYPE   => '3个及以上',
        self::STEP_THREE_TYPE => '5个及以上',
    ];

    /**
     * limit count
     * @var array
     */
    protected static $limits = [
        self::ALL             => 0,
        self::STEP_ONT_TYPE   => 1,
        self::STEP_TWO_TYPE   => 3,
        self::STEP_THREE_TYPE => 5,
    ];

    /**
     * Get all limit count
     *
     * @return array
     */
    public static function acceptableLimits()
    {
        return static::$limits;
    }
}
