<?php namespace App\Src\Provider\Domain\Model;


use App\Foundation\Domain\Enum;

class ProviderAduitdetailsType extends Enum
{
    const  REPORT_TYPE_FAGQUAN = 1; //房圈验厂报告
    const  REPORT_TYPE_THIRD = 2;//第三方验厂报告


    /**
     * ProviderAduitdetailsType TYPE.
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
        self::REPORT_TYPE_FAGQUAN => '房圈验厂报告',
        self::REPORT_TYPE_THIRD    => '第三方验厂报告',
    ];
}