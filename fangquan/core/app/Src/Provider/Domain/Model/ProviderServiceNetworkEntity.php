<?php

namespace app\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;


class ProviderServiceNetworkEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $name;
    /**
     * @var int
     */
    public $provider_id;
    /**
     * @var int
     */
    public $province_id;
    /**
     * @var int
     */
    public $city_id;
    /**
     * @var string
     */
    public $address;
    /**
     * @var int
     */
    public $worker_count;
    /**
     * @var string
     */
    public $contact;
    /**
     * @var string
     */
    public $telphone;
    /**
     * @var string
     */
    public $created_at;
    /**
     * @var string
     */
    public $updated_at;
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
            'id'           => $this->id,
            'name'         => $this->name,
            'provider_id'  => $this->provider_id,
            'province_id'  => $this->province_id,
            'city_id'      => $this->city_id,
            'address'      => $this->address,
            'worker_count' => $this->worker_count,
            'contact'      => $this->contact,
            'telphone'     => $this->telphone,
            'status'       => $this->status,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}