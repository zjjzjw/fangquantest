<?php

namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValueModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_attribute_value';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'value_id',
    ];

}