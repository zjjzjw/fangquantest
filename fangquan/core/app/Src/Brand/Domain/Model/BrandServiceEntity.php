<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;


class BrandServiceEntity extends Entity
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
     * @var string
     */
    public $service_range;

    /**
     * @var string
     */
    public $warranty_range;

    /**
     * @var string
     */
    public $supply_cycle;

    /**
     * @var array
     */
    public $file;

    /**
     * @var array
     */
    public $service_model;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'             => $this->id,
            'brand_id'       => $this->brand_id,
            'service_range'  => $this->service_range,
            'warranty_range' => $this->warranty_range,
            'supply_cycle'   => $this->supply_cycle,
            'file'           => $this->file,
            'service_model'  => $this->service_model,
            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),
        ];
    }
}