<?php namespace App\Src\Product\Domain\Model;

use App\Foundation\Domain\Entity;

class ProductCategoryEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $name;

    /**
     * @var int
     */
    public $parent_id;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $sort;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $attribfield;

    /**
     * @var int
     */
    public $is_leaf;

    /**
     * @var int
     */
    public $level;

    /**
     * @var int
     */
    public $logo;

    /**
     * @var string
     */
    public $icon;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'parent_id'   => $this->parent_id,
            'status'      => $this->status,
            'sort'        => $this->sort,
            'description' => $this->description,
            'attribfield' => $this->attribfield,
            'is_leaf'     => $this->is_leaf,
            'level'       => $this->level,
            'icon'        => $this->icon,
            'logo'        => $this->logo,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}