<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_category';

    protected $fillable = [
        'developer_project_id',
        'product_category_id',
    ];
}