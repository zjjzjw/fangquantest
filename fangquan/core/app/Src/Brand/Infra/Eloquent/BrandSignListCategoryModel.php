<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSignListCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_sign_list_category';

    protected $fillable = [
        'project_sign_id',
        'category_id',
    ];
}