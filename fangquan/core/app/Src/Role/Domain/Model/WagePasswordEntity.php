<?php

namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\Entity;

class WagePasswordEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var string
     */
    public $password;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'            => $this->id,
            'project_name'  => $this->user_id,
            'product_model' => $this->password,
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),

        ];
    }
}