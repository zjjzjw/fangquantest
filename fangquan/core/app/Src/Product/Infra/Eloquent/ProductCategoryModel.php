<?php namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_category';

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
        'icon',
    ];
}