<?php namespace App\Src\Loupan\Domain\Model;

use App\Foundation\Domain\Entity;

class LoupanEntity extends Entity
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
    public $province_id;
    /**
     * @var int
     */
    public $city_id;
    /**
     * @var array
     */
    public $loupan_developers;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'province_id'       => $this->province_id,
            'city_id'           => $this->city_id,
            'loupan_developers' => $this->loupan_developers,
            'created_at'        => $this->created_at->toDateTimeString(),
            'updated_at'        => $this->updated_at->toDateTimeString(),
        ];
    }
}