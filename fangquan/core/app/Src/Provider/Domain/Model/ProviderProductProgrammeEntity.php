<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ProviderProductProgrammeEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $desc;

    /**
     * @var integer
     */
    public $status;

    /**
     * @var integer
     */
    public $provider_id;

    /**
     * @var array
     */
    public $product;

    /**
     * @var array
     */
    public $provider_product_programme_pictures;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                                  => $this->id,
            'title'                               => $this->title,
            'desc'                                => $this->desc,
            'status'                              => $this->status,
            'provider_id'                         => $this->provider_id,
            'product'                             => $this->product,
            'provider_product_programme_pictures' => $this->provider_product_programme_pictures,
            'created_at'                          => $this->created_at->toDateTimeString(),
            'updated_at'                          => $this->updated_at->toDateTimeString(),
        ];
    }

}