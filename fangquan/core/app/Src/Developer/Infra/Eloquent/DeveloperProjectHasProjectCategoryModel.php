<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectHasProjectCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_has_project_category';

    protected $fillable = [
        'developer_project_id',
        'project_category_id',
    ];
}