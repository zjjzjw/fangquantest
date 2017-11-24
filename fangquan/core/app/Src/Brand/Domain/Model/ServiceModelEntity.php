<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;


class ServiceModelEntity extends Entity
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
    public $model_type;



    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [

            'service_id'         => $this->service_id,
            'model_type'         => $this->model_type,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }
}