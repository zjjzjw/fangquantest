<?php
namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ProviderMainCategoryEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var int
     */
    public $provider_id;

    /**
     * @var int
     */
    public $product_category_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                  => $this->id,
            'provider_id'         => $this->provider_id,
            'product_category_id' => $this->product_category_id,
            'created_at'          => $this->created_at->toDateTimeString(),
            'updated_at'          => $this->updated_at->toDateTimeString(),
        ];
    }

}