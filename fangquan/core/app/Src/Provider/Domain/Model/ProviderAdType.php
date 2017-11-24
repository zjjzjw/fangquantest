<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderAdType extends Enum
{
    const YES = 1;
    const NO = 2;


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

        self::YES  => '是',
        self::NO => '否',
    ];


}