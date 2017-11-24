<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandFactoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_factory';

    protected $dates = [

    ];

    protected $fillable = [
        'brand_id',
        'factory_type',
        'province_id',
        'city_id',
        'unit',
        'production_area',
        'address',
        'status',
    ];
}