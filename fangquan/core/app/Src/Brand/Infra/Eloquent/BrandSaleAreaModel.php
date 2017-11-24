<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSaleAreaModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_sale_area';

    protected $dates = [

    ];

    protected $fillable = [
        'brand_sale_id',
        'area_id',
    ];
}