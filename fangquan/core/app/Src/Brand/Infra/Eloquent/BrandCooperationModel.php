<?php

namespace App\Src\Brand\Infra\Eloquent;

use App\Src\Category\Infra\Eloquent\CategoryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCooperationModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_cooperation';

    protected $dates = [

    ];

    protected $fillable = [
        'brand_id',
        'developer_id',
        'developer_name',
        'deadline',
        'is_exclusive',
        'status',
    ];

    public function brand_cooperation_categorys()
    {
        return $this->belongsToMany(CategoryModel::class, 'brand_cooperation_category', 'brand_cooperation_id', 'category_id')->withTimestamps();
    }
}