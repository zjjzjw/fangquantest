<?php

namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Enum;

class FqUserFeedbackStatus extends Enum
{
    const  HANDLE = 1; //已处理
    const  NOT_HANDLE = 2; //未处理

    /**
     * FqUserProjectStatus TYPE.
     *
     * @var int
     */
    public $status;

    /**
     * Define property name of enum value.
     *
     * @var string
     */
    protected $enum = 'status';

    /**
     * Acceptable operation  model Type.
     *
     * @var array
     */
    protected static $enums = [
        self::HANDLE     => '已处理',
        self::NOT_HANDLE => '未处理',
    ];
}