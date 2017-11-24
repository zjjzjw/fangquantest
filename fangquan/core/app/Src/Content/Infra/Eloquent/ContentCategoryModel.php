<?php namespace App\Src\Content\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContentCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'content_category';

    protected $fillable = [
        'name',
        'parent_id',
        'status',

    ];
}