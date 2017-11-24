<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCustomProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'custom_product';
    protected $dates = [
    ];
    protected $fillable = [
        'product_name',
        'brand_id',
        'developer_id',
        'loupan_id',

    ];


}