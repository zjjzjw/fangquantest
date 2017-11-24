<?php

namespace App\Src\Category\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Category\Infra\Eloquent\CategoryAttributeModel;
use App\Src\Category\Infra\Eloquent\CategoryParamModel;

class CategoryEntity extends Entity
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
    public $parent_id;

    /**
     * @var int
     */
    public $order;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $image_id;

    /**
     * @var string
     */
    public $price;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var array
     */
    public $category_attributes;

    /**
     * @var array
     */
    public $category_attribute_ids;

    /**
     * @var array
     */
    public $category_params;

    /**
     * @var string
     */
    public $icon_font;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                     => $this->id,
            'name'                   => $this->name,
            'parent_id'              => $this->parent_id,
            'order'                  => $this->order,
            'status'                 => $this->status,
            'price'                  => $this->price,
            'image_id'               => $this->image_id,
            'created_user_id'        => $this->created_user_id,
            'category_attributes'    => $this->category_attributes,
            'category_attribute_ids' => $this->category_attribute_ids,
            'category_params'        => $this->category_params,
            'icon_font'              => $this->icon_font,
            'created_at'             => $this->created_at->toDateTimeString(),
            'updated_at'             => $this->updated_at->toDateTimeString(),
        ];
    }
}