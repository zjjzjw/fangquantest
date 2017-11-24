<?php

namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'brand_id',
        'product_category_id',
        'product_model',
        'price',
        'created_user_id',
        'logo',
        'comment_count',
        'product_type',
        'product_grade',
        'price_unit',
        'name',
        'retail_price',
        'engineering_price',
        'product_discount_rate',
    ];

    public function product_pictures()
    {
        return $this->hasMany(ProductPictureModel::class, 'product_id', 'id');
    }

    public function product_attribute_values()
    {
        return $this->hasMany(ProductAttributeValueModel::class, 'product_id', 'id');
    }

    public function product_params()
    {
        return $this->hasMany(ProductParamModel::class, 'product_id', 'id');
    }

    public function product_dynamic_params()
    {
        return $this->hasMany(ProductDynamicParamModel::class, 'product_id', 'id');
    }

    public function product_hots()
    {
        return $this->hasMany(ProductHotModel::class, 'product_id', 'id');
    }
}