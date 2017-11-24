<?php
namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\Entity;

class PermissionEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';


    /**
     * @var Carbon
     */
    public $name;

    /**
     * @var int
     */
    public $desc;

    /**
     * @var string
     */
    public $code;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'code'       => $this->code,
            'desc'       => $this->desc,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}