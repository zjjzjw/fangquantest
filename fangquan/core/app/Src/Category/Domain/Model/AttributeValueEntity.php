<?php

namespace App\Src\Category\Domain\Model;


use App\Foundation\Domain\Entity;

class AttributeValueEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $attribute_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $order;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'order'        => $this->order,
            'attribute_id' => $this->attribute_id,
            'created_at'   => $this->created_at->toDateTimeString(),
            'updated_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}