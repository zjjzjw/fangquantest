<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderFriendEntity extends Entity
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
    public $name;

    /**
     * @var string
     */
    public $logo;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $link;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'provider_id' => $this->provider_id,
            'name'        => $this->name,
            'logo'        => $this->logo,
            'link'        => $this->link,
            'status'      => $this->status,
            'created_at'  =>$this->created_at
        ];
    }

}