<?php

namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\Enum;

class ContentTimingPublishType extends Enum
{
    const YES = 1;//是
    const NO = 2;//否


    /**
     * DeveloperStatus status.
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
        self::YES => '是',
        self::NO  => '否',
    ];
}