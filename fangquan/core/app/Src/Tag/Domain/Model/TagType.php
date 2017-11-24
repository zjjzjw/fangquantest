<?php namespace App\Src\Tag\Domain\Model;

use App\Foundation\Domain\Enum;

class TagType extends Enum
{

    const PRODUCT = 1;
    const INFORMATION = 2;

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
        self::PRODUCT     => '产品',
        self::INFORMATION => '资讯',
    ];


}