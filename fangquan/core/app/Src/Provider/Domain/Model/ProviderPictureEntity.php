<?php
namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ProviderPictureEntity extends Entity
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
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $image_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'provider_id' => $this->provider_id,
            'type'        => $this->type,
            'image_id'    => $this->image_id,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }

}