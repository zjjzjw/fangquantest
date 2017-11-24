<?php

namespace App\Src\MediaManagement\Domain\Model;

use App\Foundation\Domain\Enum;

/**
 * 开发商类型
 * Class MediaManagementProjectType
 * @package App\Src\MediaManagement\Domain\Model
 */
class MediaManagementType extends Enum
{
    const TELEVIDION = 1;//电视媒体Television media
    const PRINTED    = 2;//平面媒体Printed media
    const NETWORK    = 3;//网络媒体Network media


    /**
     * OperationModelType type.
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
        self::TELEVIDION   => '电视媒体',
        self::PRINTED      => '平面媒体',
        self::NETWORK      => '网络媒体',
    ];
}