<?php namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Entity;

class DeveloperEntity extends Entity
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
    public $status;

    /**
     * @var int
     */
    public $rank;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'logo'       => $this->logo,
            'status'     => $this->status,
            'rank'       => $this->rank,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}