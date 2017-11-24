<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProductProgrammeFavoriteEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $product_programme_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                   => $this->id,
            'user_id'              => $this->user_id,
            'product_programme_id' => $this->product_programme_id,
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }

}
