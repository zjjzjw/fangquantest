<?php

namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductParamModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_param';

    protected $fillable = [
        'category_param_id',
        'product_id',
        'name',
        'value',
    ];

}