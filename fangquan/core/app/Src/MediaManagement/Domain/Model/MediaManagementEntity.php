<?php namespace App\Src\MediaManagement\Domain\Model;

use App\Foundation\Domain\Entity;

class MediaManagementEntity extends Entity
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
    public $logo;

    /**
     * @var int
     */
    public $type;



    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'logo'       => $this->logo,
            'type'       => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}