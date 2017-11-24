<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 项目招标类型
 * Class DeveloperProjectBiddingType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectBiddingType extends Enum
{
    const PROJECT_BIDDING_TYPE = 1;//项目招标
    const PROJECT_JICAI_TYPE = 2;//战略集采

    /**
     * DeveloperProjectBiddingType type.
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
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::PROJECT_BIDDING_TYPE => '项目招标',
        self::PROJECT_JICAI_TYPE   => '战略集采招标',
    ];

}