<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Brand\Infra\Eloquent\BrandCategoryModel;
use Carbon\Carbon;

class BrandFactoryEntity extends Entity
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
    public $factory_type;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var string
     */
    public $production_area;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $unit;


    /**
     * @var int
     */
    public $status;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'              => $this->id,
            'province_id'     => $this->province_id,
            'city_id'         => $this->city_id,
            'brand_id'        => $this->brand_id,
            'factory_type'    => $this->factory_type,
            'production_area' => $this->production_area,
            'address'         => $this->address,
            'unit'            => $this->unit,
            'status'          => $this->status,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }
}