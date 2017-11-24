<?php

namespace App\Src\Product\Domain\Model;


use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ProductParamEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $product_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'name'       => $this->name,
            'value'      => $this->value,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}