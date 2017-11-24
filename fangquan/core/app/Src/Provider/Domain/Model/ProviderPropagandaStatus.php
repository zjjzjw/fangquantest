<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderPropagandaStatus extends Enum
{
    const STATUS_INIT = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;


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
    protected $enum = 'status';

    /**
     * Acceptable operation  model type.
     *
     * @var array
     */
    protected static $enums = [
        self::STATUS_INIT   => '待审核',
        self::STATUS_PASS   => '审核通过',
        self::STATUS_REJECT => '审核驳回',
    ];
}