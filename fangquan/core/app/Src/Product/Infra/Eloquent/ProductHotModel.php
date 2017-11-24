<?php

namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductHotModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_hot';

    protected $fillable = [
        'product_id',
        'product_hot_type',
    ];

}