<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectFavoriteModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_favorite';

    protected $fillable = [
        'user_id',
        'developer_project_id',
    ];
}