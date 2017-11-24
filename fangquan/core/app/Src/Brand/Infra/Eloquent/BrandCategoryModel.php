<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_category';

    protected $fillable = [
        'brand_id',
        'category_id',
    ];

}