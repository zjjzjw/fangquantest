<?php
namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ProviderProductEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $provider_id;

    /**
     * @var int
     */
    public $product_category_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $views;

    /**
     * @var string
     */
    public $attrib;

    /**
     * @var int
     */
    public $attrib_integrity;

    /**
     * @var string
     */
    public $price_low;

    /**
     * @var string
     */
    public $price_high;

    /**
     * @var int
     */
    public $status;

    /**
     * @var array
     */
    public $provider_product_images;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                      => $this->id,
            'provider_id'             => $this->provider_id,
            'product_category_id'     => $this->product_category_id,
            'name'                    => $this->name,
            'views'                   => $this->views,
            'attrib'                  => $this->attrib,
            'attrib_integrity'        => $this->attrib_integrity,
            'price_low'               => $this->price_low,
            'price_high'              => $this->price_high,
            'status'                  => $this->status,
            'provider_product_images' => $this->provider_product_images,
            'created_at'              => $this->created_at->toDateTimeString(),
            'updated_at'              => $this->updated_at->toDateTimeString(),
        ];
    }

}