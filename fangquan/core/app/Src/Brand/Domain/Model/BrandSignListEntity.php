<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class BrandSignListEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $loupan_id;

    /**
     * @var int
     */
    public $brand_total_amount;
    /**
     * @var int
     */
    public $brand_id;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $product_model;

    /**
     * @var int
     */
    public $delivery_num;

    /**
     * @var Carbon
     */
    public $order_sign_time;

    /**
     * @var array
     */
    public $brand_sign_categorys;

    /**
     * @var array
     */
    public $project_developers;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                   => $this->id,
            'loupan_id'            => $this->loupan_id,
            'brand_id'             => $this->brand_id,
            'province_id'          => $this->province_id,
            'city_id'              => $this->city_id,
            'product_model'        => $this->product_model,
            'status'               => $this->status,
            'delivery_num'         => $this->delivery_num,
            'brand_total_amount'   => $this->brand_total_amount,
            'brand_sign_categorys' => $this->brand_sign_categorys,
            'project_developers'   => $this->project_developers,
            'order_sign_time'      => $this->order_sign_time->toDateTimeString(),
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }
}