<?php

namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserPermissionProjectAreaType extends Enum
{
    const NORTH = 1; // 华北
    const SOUTH = 2; // 华南
    const EAST = 3; // 华东
    const CENTER = 4; // 华中
    const WEST = 8; // 华西

    /**
     * FqUserPermissionProjectAreaType TYPE.
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
     * Acceptable progress status.
     *
     * @var array
     */
    protected static $enums = [

        self::NORTH  => '华北',
        self::SOUTH  => '华南',
        self::EAST   => '华东',
        self::CENTER => '华中',
        self::WEST   => '华西',
    ];
}