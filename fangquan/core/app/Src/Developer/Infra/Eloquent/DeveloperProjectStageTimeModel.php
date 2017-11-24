<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectStageTimeModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_stage_time';

    protected $dates = [
        'time',
    ];

    protected $fillable = [
        'project_id',
        'time',
        'stage_type',
    ];
}