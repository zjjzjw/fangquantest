<?php

namespace App\Src\Tag\Domain\Model;


use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class TagEntity extends Entity
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
    public $created_user_id;

    /**
     * @var int
     */
    public $order;

    /**
     * @var int
     */
    public $type;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'created_user_id' => $this->created_user_id,
            'order'           => $this->order,
            'type'            => $this->type,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }
}