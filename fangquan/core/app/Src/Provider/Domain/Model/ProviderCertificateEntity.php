<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderCertificateEntity extends Entity
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
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $image_id;
    /**
     * @var int
     */
    public $type;
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
            'name'        => $this->name,
            'image_id'    => $this->image_id,
            'type'        => $this->type,
            'status'      => $this->status,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}