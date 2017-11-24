<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCooperationCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_cooperation_category';

    protected $fillable = [
        'brand_cooperation_id',
        'category_id',
    ];
}