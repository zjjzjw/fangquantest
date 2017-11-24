<?php namespace App\Src\Product\Domain\Model;

use App\Foundation\Domain\Entity;

class CategoryEntity extends Entity
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
     * @var int
     */
    public $rank;

    /**
     * @var int
     */
    public $image;

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
            'id'         => $this->id,
            'name'       => $this->name,
            'parent_id'  => $this->parent_id,
            'status'     => $this->status,
            'sort'       => $this->sort,
            'rank'       => $this->rank,
            'image'      => $this->image,
            'icon'       => $this->icon,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}