<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;


class BrandCustomProductEntity extends Entity
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
    public $loupan_id;
    /**
     * @var int
     */
    public $developer_id;


    /**
     * @var int
     */
    public $product_name;
    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                 => $this->id,
            'product_name'       => $this->product_name,
            'brand_id'           => $this->brand_id,
            'developer_id'       => $this->developer_id,
            'loupan_id'       =>    $this->loupan_id,
            'created_at'         => $this->created_at->toDateTimeString(),
            'updated_at'         => $this->updated_at->toDateTimeString(),
        ];
    }
}