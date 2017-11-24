<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectStageModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_stage';

    protected $fillable = [
        'name',
        'sort'
    ];
}