<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderProductPictureEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $provider_product_id;

    /**
     * @var int
     */
    public $image_id;


    public function toArray($is_filter_null = false)
    {
        return [
            'id'                  => $this->id,
            'provider_product_id' => $this->provider_product_id,
            'image_id'            => $this->image_id,
            'created_at'          => $this->created_at->toDateTimeString(),
            'updated_at'          => $this->updated_at->toDateTimeString(),
        ];
    }

    public function __construct()
    {
    }

}