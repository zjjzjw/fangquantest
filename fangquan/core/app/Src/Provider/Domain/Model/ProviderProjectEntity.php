<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;
use App\Src\Provider\Infra\Eloquent\ProviderProjectPictureModel;
use App\Src\Provider\Infra\Eloquent\ProviderProjectProductModel;

class ProviderProjectEntity extends Entity
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
     * @var string
     */
    public $developer_name;
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
    public $time;
    /**
     * @var int
     */
    public $status;
    /**
     * @var array|ProviderProjectPictureEntity
     */
    public $provider_project_picture_ids;
    /**
     * @var array|ProviderProjectProductEntity
     */
    public $provider_project_products;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                           => $this->id,
            'provider_id'                  => $this->provider_id,
            'name'                         => $this->name,
            'developer_name'               => $this->developer_name,
            'province_id'                  => $this->province_id,
            'city_id'                      => $this->city_id,
            'time'                         => $this->time,
            'status'                       => $this->status,
            'provider_project_picture_ids' => $this->provider_project_picture_ids,
            'provider_project_products'    => $this->provider_project_products,
            'created_at'                   => $this->created_at->toDateTimeString(),
            'updated_at'                   => $this->updated_at->toDateTimeString(),
        ];
    }
}