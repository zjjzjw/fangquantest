<?php

namespace App\Src\Theme\Domain\Model;


use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ThemeEntity extends Entity
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
    public $type;

    /**
     * @var int
     */
    public $created_user_id;

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
            'id'              => $this->id,
            'name'            => $this->name,
            'type'            => $this->type,
            'order'           => $this->order,
            'created_user_id' => $this->created_user_id,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }
}