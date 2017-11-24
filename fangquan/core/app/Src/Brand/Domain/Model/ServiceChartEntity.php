<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;


class ServiceChartEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $service_id;

    /**
     * @var int
     */
    public $image_id;



    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [

            'service_id'         => $this->service_id,
            'image_id'         => $this->image_id,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }
}