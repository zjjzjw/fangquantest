<?php namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class DeveloperProjectBrowseEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $type;

    /**
     * @var int
     */
    public $p_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'type'       => $this->type,
            'user_id'    => $this->user_id,
            'p_id'       => $this->p_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}