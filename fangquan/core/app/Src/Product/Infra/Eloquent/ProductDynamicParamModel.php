<?php

namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDynamicParamModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_dynamic_param';

    protected $fillable = [
        'product_id',
        'param_name',
        'param_value',
    ];

}