<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectCategoryTypeModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_category_type';

    protected $fillable = [
        'project_id',
        'project_category_id',
    ];
}