<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderStatus extends Enum
{
    const NO_CERTIFIED = 1;
    const YES_CERTIFIED = 2;
    const DOWN_SHELF = 3;


    /**
     * loan type.
     *
     * @var string
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

        self::NO_CERTIFIED  => '未认证',
        self::YES_CERTIFIED => '已认证',
        self::DOWN_SHELF    => '下架',
    ];


}