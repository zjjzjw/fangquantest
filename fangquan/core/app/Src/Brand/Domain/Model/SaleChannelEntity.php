<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;

class SaleChannelEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $channel_type;

    /**
     * @var string
     */
    public $sale_year;
    /**
     * @var string
     */
    public $brand_id;
    /**
     * @var float
     */
    public $sale_volume;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'           => $this->id,
            'channel_type' => $this->channel_type,
            'brand_id'     => $this->brand_id,
            'sale_year'    => $this->sale_year,
            'sale_volume'  => $this->sale_volume,
            'created_at'   => $this->created_at->toDateTimeString(),
            'updated_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}