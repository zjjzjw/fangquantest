<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class OperationModelType extends Enum
{
    const ALL = 0; //未知
    const MANUFACTURER = 1;//生产厂商
    const DEALER = 2;//经销商


    /**
     * OperationModelType TYPE.
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
        self::ALL          => '未知',
        self::MANUFACTURER => '生产厂商',
        self::DEALER       => '经销商',
    ];
}