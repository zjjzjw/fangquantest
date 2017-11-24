<?php
namespace App\Src\Surport\Domain\Model;

use App\Foundation\Domain\Entity;

class ChinaAreaEntity extends Entity
{

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }

}