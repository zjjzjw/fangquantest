<?php namespace App\Src\Product\Domain\Model;


use App\Foundation\Domain\Enum;

class ProductCategoryType extends Enum
{
    const FURNISHINGS = 1;
    const WATER_HEATER = 2;
    const BATHROOM = 3;
    const CUPBOARD = 4;
    const KITCHEN_APPLIANCE = 5;
    const ENTRY_DOOR = 6;
    const SWITCH_BOX = 7;
    const WOOD_FLOOR = 8;
    const PIPE = 9;
    const ELEVATOR = 10;
    const FRESH_AIR_SYSTEM = 11;
    const INTERIOR_PAINT = 12;
    const WATERPROOF_MATERIAL = 13;
    const INTEGRATED_CEILING = 14;
    const AIR_CONDITIONING = 15;
    const WASTE_PROCESSOR = 16;
    const WALL_HANGING_STOVE = 17;
    const TILES = 18;
    const SWITCH_PANEL = 19;
    const INDOOR_LIGHTING = 20;
    const VISUAL_INTERCOM = 21;
    const INDOOR_WALLPAPER = 22;
    const SMART_HOME = 23;
    const WATER_CLEANER = 24;
    const RECEIVE_SYSTEM = 25;
    const WINDOWS_DOORS_PROFILES = 26;
    const DOOR_WINDOW_HARDWARE = 27;


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
        self::FURNISHINGS            => '装饰材料',
        self::WATER_HEATER           => '热水器',
        self::BATHROOM               => '卫浴',
        self::CUPBOARD               => '橱柜',
        self::KITCHEN_APPLIANCE      => '厨房电器',
        self::ENTRY_DOOR             => '入户门',
        self::SWITCH_BOX             => '配电箱',
        self::WOOD_FLOOR             => '木地板',
        self::PIPE                   => '管材',
        self::ELEVATOR               => '电梯',
        self::FRESH_AIR_SYSTEM       => '新风系统',
        self::INTERIOR_PAINT         => '室内涂料',
        self::WATERPROOF_MATERIAL    => '防水材料',
        self::INTEGRATED_CEILING     => '集成吊顶',
        self::AIR_CONDITIONING       => '空调',
        self::WASTE_PROCESSOR        => '垃圾处理器',
        self::WALL_HANGING_STOVE     => '壁挂炉',
        self::TILES                  => '瓷砖',
        self::SWITCH_PANEL           => '开关面板',
        self::INDOOR_LIGHTING        => '室内灯饰',
        self::VISUAL_INTERCOM        => '可视对讲',
        self::INDOOR_WALLPAPER       => '室内壁纸',
        self::SMART_HOME             => '智能家居',
        self::WATER_CLEANER          => '净水器',
        self::RECEIVE_SYSTEM         => '收纳系统',
        self::WINDOWS_DOORS_PROFILES => '门窗型材',
        self::DOOR_WINDOW_HARDWARE   => '门窗五金',
    ];


    protected static $icon_enums = [
        self::WATER_HEATER           => '&#xe626;',
        self::BATHROOM               => '&#xe63b;',
        self::CUPBOARD               => '&#xe630;',
        self::KITCHEN_APPLIANCE      => '&#xe688;',
        self::ENTRY_DOOR             => '&#xe70d;',
        self::SWITCH_BOX             => '&#xe64d;',
        self::WOOD_FLOOR             => '&#xe685;',
        self::PIPE                   => '&#xe64f;',
        self::ELEVATOR               => '&#xe649;',
        self::FRESH_AIR_SYSTEM       => '&#xe64a;',
        self::INTERIOR_PAINT         => '&#xe64c;',
        self::WATERPROOF_MATERIAL    => '&#xe62f;',
        self::INTEGRATED_CEILING     => '&#xe6a9;',
        self::AIR_CONDITIONING       => '&#xe64e;',
        self::WASTE_PROCESSOR        => '&#xe652;',
        self::WALL_HANGING_STOVE     => '&#xe658;',
        self::TILES                  => '&#xe659;',
        self::SWITCH_PANEL           => '&#xe651;',
        self::INDOOR_LIGHTING        => '&#xe655;',
        self::VISUAL_INTERCOM        => '&#xe62d;',
        self::INDOOR_WALLPAPER       => '&#xe656;',
        self::SMART_HOME             => '&#xe65a;',
        self::WATER_CLEANER          => '&#xe633;',
        self::RECEIVE_SYSTEM         => '&#xe654;',
        self::WINDOWS_DOORS_PROFILES => '&#xe62b;',
        self::DOOR_WINDOW_HARDWARE   => '&#xe650;',
    ];

    protected static $app_icon_enums = [
        self::WATER_HEATER           => 'http://img-dev.fq960.com/product_category/icon-26.png',
        self::BATHROOM               => 'http://img-dev.fq960.com/product_category/icon-02.png',
        self::CUPBOARD               => 'http://img-dev.fq960.com/product_category/icon-19.png',
        self::KITCHEN_APPLIANCE      => 'http://img-dev.fq960.com/product_category/icon-11.png',
        self::ENTRY_DOOR             => 'http://img-dev.fq960.com/product_category/icon-21.png',
        self::SWITCH_BOX             => 'http://img-dev.fq960.com/product_category/icon-04.png',
        self::WOOD_FLOOR             => 'http://img-dev.fq960.com/product_category/icon-06.png',
        self::PIPE                   => 'http://img-dev.fq960.com/product_category/icon-07.png',
        self::ELEVATOR               => 'http://img-dev.fq960.com/product_category/icon-08.png',
        self::FRESH_AIR_SYSTEM       => 'http://img-dev.fq960.com/product_category/icon-23.png',
        self::INTERIOR_PAINT         => 'http://img-dev.fq960.com/product_category/icon-01.png',
        self::WATERPROOF_MATERIAL    => 'http://img-dev.fq960.com/product_category/icon-24.png',
        self::INTEGRATED_CEILING     => 'http://img-dev.fq960.com/product_category/icon-05.png',
        self::AIR_CONDITIONING       => 'http://img-dev.fq960.com/product_category/icon-10.png',
        self::WASTE_PROCESSOR        => 'http://img-dev.fq960.com/product_category/icon-12.png',
        self::WALL_HANGING_STOVE     => 'http://img-dev.fq960.com/product_category/icon-16.png',
        self::TILES                  => 'http://img-dev.fq960.com/product_category/icon-13.png',
        self::SWITCH_PANEL           => 'http://img-dev.fq960.com/product_category/icon-18.png',
        self::INDOOR_LIGHTING        => 'http://img-dev.fq960.com/product_category/icon-17.png',
        self::VISUAL_INTERCOM        => 'http://img-dev.fq960.com/product_category/icon-15.png',
        self::INDOOR_WALLPAPER       => 'http://img-dev.fq960.com/product_category/icon-09.png',
        self::SMART_HOME             => 'http://img-dev.fq960.com/product_category/icon-20.png',
        self::WATER_CLEANER          => 'http://img-dev.fq960.com/product_category/icon-25.png',
        self::RECEIVE_SYSTEM         => 'http://img-dev.fq960.com/product_category/icon-22.png',
        self::WINDOWS_DOORS_PROFILES => 'http://img-dev.fq960.com/product_category/icon-14.png',
        self::DOOR_WINDOW_HARDWARE   => 'http://img-dev.fq960.com/product_category/icon-03.png',
    ];

    protected static $app_colour_enums = [
        self::WATER_HEATER           => '84bc7f',
        self::BATHROOM               => '84bc7f',
        self::CUPBOARD               => '84bc7f',
        self::KITCHEN_APPLIANCE      => '84bc7f',
        self::ENTRY_DOOR             => '84bc7f',
        self::SWITCH_BOX             => '22c5ca',
        self::WOOD_FLOOR             => '22c5ca',
        self::PIPE                   => '22c5ca',
        self::ELEVATOR               => '22c5ca',
        self::FRESH_AIR_SYSTEM       => '22c5ca',
        self::INTERIOR_PAINT         => 'ff8c77',
        self::WATERPROOF_MATERIAL    => 'ff8c77',
        self::INTEGRATED_CEILING     => 'ff8c77',
        self::AIR_CONDITIONING       => 'ff8c77',
        self::WASTE_PROCESSOR        => 'ff8c77',
        self::WALL_HANGING_STOVE     => '7c98bd',
        self::TILES                  => '7c98bd',
        self::SWITCH_PANEL           => '7c98bd',
        self::INDOOR_LIGHTING        => '7c98bd',
        self::VISUAL_INTERCOM        => '7c98bd',
        self::INDOOR_WALLPAPER       => 'ffac5c',
        self::SMART_HOME             => 'ffac5c',
        self::WATER_CLEANER          => 'ffac5c',
        self::RECEIVE_SYSTEM         => 'ffac5c',
        self::WINDOWS_DOORS_PROFILES => 'ffac5c',
        self::DOOR_WINDOW_HARDWARE   => 'ffac5c',
    ];

    protected static $app_top_six_category_enums = [

        self::KITCHEN_APPLIANCE => 'http://img-dev.fq960.com/product_category/top6/chufang.png',
        self::CUPBOARD          => 'http://img-dev.fq960.com/product_category/top6/chuju.png',
        self::WOOD_FLOOR        => 'http://img-dev.fq960.com/product_category/top6/mudiban.png',
        self::SWITCH_BOX        => 'http://img-dev.fq960.com/product_category/top6/peidian.png',
        self::ENTRY_DOOR        => 'http://img-dev.fq960.com/product_category/top6/rumeng.png',
        self::BATHROOM          => 'http://img-dev.fq960.com/product_category/top6/weiyu.png',
    ];

    public static function acceptableIconEnums()
    {
        return static::$icon_enums;
    }

    public static function acceptableAppIconEnums()
    {
        return static::$app_icon_enums;
    }

    public static function acceptableAppColourEnums()
    {
        return static::$app_colour_enums;
    }

    public static function acceptableAppTopColourEnums()
    {
        return static::$app_top_six_category_enums;
    }

}