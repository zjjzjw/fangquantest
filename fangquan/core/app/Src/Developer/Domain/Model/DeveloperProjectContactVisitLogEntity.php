<?php namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Entity;

class DeveloperProjectContactVisitLogEntity extends Entity
{
    /**
     * @var int
     */
    public $user_id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $developer_project_id;
    /**
     * @var int
     */
    public $role_type;
    /**
     * @var int
     */
    public $role_id;

    public function toArray($is_filter_null = false)
    {
        return [
            'user_id'              => $this->user_id,
            'developer_project_id' => $this->developer_project_id,
            'role_type'            => $this->role_type,
            'role_id'              => $this->role_id,
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }

    public function __construct()
    {
    }
}