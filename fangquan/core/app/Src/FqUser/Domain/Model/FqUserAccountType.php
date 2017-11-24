<?php

namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserAccountType extends Enum
{
    const  TYPE_FREE = 1; // 免费账号
    //const  TYPE_PROBATION = 2; // 试用账号
    const  TYPE_FORMAL = 3; // 正式账号



    /**
     * FqUserProjectStatus TYPE.
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
     * Acceptable operation  model Type.
     *
     * @var array
     */
    protected static $enums = [
        self::TYPE_FREE      => '免费账号',
        //self::TYPE_PROBATION => '试用账号',
        self::TYPE_FORMAL    => '正式账号',
    ];
}