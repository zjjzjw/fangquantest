<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class RegisteredCapitalType extends Enum
{
    const ALL = 0;
    const STEP_ONT_TYPE = 1;
    const STEP_TWO_TYPE = 2;
    const STEP_THREE_TYPE = 3;
    const STEP_FOUR_TYPE = 4;
    const STEP_FIVE_TYPE = 5;
    const STEP_SIX_TYPE = 6;

    /**
     * SearchType TYPE.
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
     * Acceptable search type.
     *
     * @var array
     */
    protected static $enums = [
        self::ALL             => '不限',
        self::STEP_ONT_TYPE   => '100万以下',
        self::STEP_TWO_TYPE   => '100万-500万',
        self::STEP_THREE_TYPE => '500万-1000万',
        self::STEP_FOUR_TYPE  => '1000万-5000万',
        self::STEP_FIVE_TYPE  => '5000万-1亿',
        self::STEP_SIX_TYPE   => '1亿以上',
    ];

    protected static $ranges = [
        self::ALL             => [],
        self::STEP_ONT_TYPE   => [0, 100],
        self::STEP_TWO_TYPE   => [100, 500],
        self::STEP_THREE_TYPE => [500, 1000],
        self::STEP_FOUR_TYPE  => [1000, 5000],
        self::STEP_FIVE_TYPE  => [5000, 10000],
        self::STEP_SIX_TYPE   => [10000, null],
    ];

    /**
     * @return array
     */
    public static function acceptableRanges()
    {
        return self::$ranges;
    }
}
