<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectBrowseModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_browse';

    protected $fillable = [
        'user_id',
        'p_id',
        'type',
    ];
}