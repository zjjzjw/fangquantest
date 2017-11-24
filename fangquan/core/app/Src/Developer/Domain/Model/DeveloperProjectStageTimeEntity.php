<?php namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class DeveloperProjectStageTimeEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $project_id;

    /**
     * @var int
     */
    public $stage_type;

    /**
     * @var Carbon
     */
    public $time;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'project_id' => $this->project_id,
            'stage_type' => $this->stage_type,
            'time'       => $this->time,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}