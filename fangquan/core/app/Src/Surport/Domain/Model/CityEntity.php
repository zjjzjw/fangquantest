<?php
namespace App\Src\Surport\Domain\Model;

use App\Foundation\Domain\Entity;

class CityEntity extends Entity
{

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var float
     */
    public $lng;

    /**
     * @var float
     */
    public $lat;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'province_id' => $this->province_id,
            'name'        => $this->name,
            'lng'         => $this->lng,
            'lat'         => $this->lat,
        ];
    }

}