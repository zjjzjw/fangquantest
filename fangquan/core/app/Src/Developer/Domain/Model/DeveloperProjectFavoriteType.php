<?php

namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 操作类型
 * Class DeveloperProjectFavoriteType
 * @package App\Src\Developer\Domain\Model
 */
class DeveloperProjectFavoriteType extends Enum
{
    const COLLECT = 1;//收藏
    const NNDO = 2;//取消

    /**
     * DeveloperProjectFavoriteType type.
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
        self::COLLECT => '收藏',
        self::NNDO    => '取消',
    ];
}