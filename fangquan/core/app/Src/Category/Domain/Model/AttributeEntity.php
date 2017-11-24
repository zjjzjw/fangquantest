<?php

namespace App\Src\Category\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Category\Infra\Eloquent\AttributeValueModel;

class AttributeEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $order;
    /**
     * @var int
     */
    public $category_id;

    /**
     * @var array
     */
    public $attribute_values;

    /**
     * @var array
     */
    public $attribute_value_ids;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'order'               => $this->order,
            'category_id'               => $this->category_id,
            'attribute_values'    => $this->attribute_values,
            'attribute_value_ids' => $this->attribute_value_ids,
            'created_at'          => $this->created_at->toDateTimeString(),
            'updated_at'          => $this->updated_at->toDateTimeString(),
        ];
    }
}