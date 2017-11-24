<?php namespace App\Src\Project\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProjectCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'project_category';

    protected $fillable = [
        'name',
        'parent_id',
        'status',
        'sort',
        'description',
        'attribfield',
        'is_leaf',
        'level',
        'logo',
        'icon_font',
    ];
}