<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderPropagandaEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    /**
     * @var int
     */
    public $provider_id;
    /**
     * @var int
     */
    public $image_id;

    /**
     * @var string
     */
    public $link;
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
            'provider_id' => $this->provider_id,
            'image_id'    => $this->image_id,
            'link'        => $this->link,
            'status'      => $this->status,
            'created_at'  =>$this->created_at->toDateTimeString(),
            'updated_at'  =>$this->updated_at->toDateTimeString(),
        ];
    }

}