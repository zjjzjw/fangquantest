<?php namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\Entity;

class ContentCategoryEntity extends Entity
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
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}