<?php

namespace App\Src\Category\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'category';

    protected $fillable = [
        'parent_id',
        'name',
        'order',
        'status',
        'price',
        'image_id',
        'created_user_id',
        'icon_font',
    ];

    public function category_attributes()
    {
        return $this->belongsToMany(AttributeModel::class, 'category_attribute', 'category_id', 'attribute_id')->withTimestamps();
    }

    public function category_params(){
        return $this->hasMany(CategoryParamModel::class, 'category_id', 'id');
    }
}