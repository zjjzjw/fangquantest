<?php
namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\Entity;

class DepartEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';


    /**
     * @var int
     */
    public $parent_id;

    /**
     * @var Carbon
     */
    public $name;

    /**
     * @var int
     */
    public $level;

    /**
     * @var int
     */
    public $desc;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'parent_id'  => $this->parent_id,
            'name'       => $this->name,
            'level'      => $this->level,
            'desc'       => $this->desc,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}