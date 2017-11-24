<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Enum;

class ProviderProductProgrammeType extends Enum
{
    const TYPE_ONLINE = 1;//分类显示
    const TYPE_OFFLINE = 2; //分类不显示


    /**
     * ProviderProductProgrammeType TYPE.
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
        self::TYPE_ONLINE  => '显示',
        self::TYPE_OFFLINE => '不显示',
    ];

}