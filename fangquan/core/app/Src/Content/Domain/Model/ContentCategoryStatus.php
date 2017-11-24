<?php

namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\Enum;

class ContentCategoryStatus extends Enum
{
    const STATUS_ONLINE = 1;//分类显示
    const STATUS_OFFLINE = 2; //分类不显示


    /**
     * ContentCategoryType TYPE.
     *
     * @var int
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable project case count type.
     *
     * @var array
     */
    protected static $enums = [
        self::STATUS_ONLINE  => '显示',
        self::STATUS_OFFLINE => '不显示',
    ];

}