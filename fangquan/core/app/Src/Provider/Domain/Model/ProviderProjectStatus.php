<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderProjectStatus extends Enum
{
    const STATUS_INIT = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;


    /**
     * loan type.
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
        self::STATUS_INIT   => '未审核',
        self::STATUS_PASS   => '审核通过',
        self::STATUS_REJECT => '审核驳回',
    ];


}