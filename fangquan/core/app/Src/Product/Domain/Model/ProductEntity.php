<?php

namespace App\Src\Product\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Product\Infra\Eloquent\ProductAttributeValueModel;
use App\Src\Product\Infra\Eloquent\ProductParamModel;
use App\Src\Product\Infra\Eloquent\ProductPictureModel;
use Carbon\Carbon;

class ProductEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $brand_id;

    /**
     * @var int
     */
    public $product_category_id;

    /**
     * @var string
     */
    public $product_model;

    /**
     * @var string
     */
    public $price;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var int
     */
    public $logo;

    /**
     * @var int
     */
    public $comment_count;

    /**
     * @var int
     */
    public $product_type;

    /**
     * @var int
     */
    public $product_grade;

    /**
     * @var array
     */
    public $product_pictures;

    /**
     * @var array
     */
    public $product_attribute_values;

    /**
     * @var array
     */
    public $product_params;

    /**
     * @var array
     */
    public $product_dynamic_params;
    /**
     * @var array
     */
    public $product_hots;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $price_unit;

    /**
     * @var float
     */
    public $engineering_price;
    /**
     * @var float
     */
    public $product_discount_rate;

    /**
     * @var float
     */
    public $retail_price;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                       => $this->id,
            'brand_id'                 => $this->brand_id,
            'product_category_id'      => $this->product_category_id,
            'product_model'            => $this->product_model,
            'price'                    => $this->price,
            'created_user_id'          => $this->created_user_id,
            'logo'                     => $this->logo,
            'comment_count'            => $this->comment_count,
            'product_pictures'         => $this->product_pictures,
            'product_attribute_values' => $this->product_attribute_values,
            'product_params'           => $this->product_params,
            'product_dynamic_params'   => $this->product_dynamic_params,
            'product_hots'             => $this->product_hots,
            'product_type'             => $this->product_type,
            'product_grade'            => $this->product_grade,
            'name'                     => $this->name,
            'price_unit'               => $this->price_unit,
            'engineering_price'        => $this->engineering_price,
            'product_discount_rate'        => $this->product_discount_rate,
            'retail_price'             => $this->retail_price,
            'created_at'               => $this->created_at->toDateTimeString(),
            'updated_at'               => $this->updated_at->toDateTimeString(),
        ];
    }
}