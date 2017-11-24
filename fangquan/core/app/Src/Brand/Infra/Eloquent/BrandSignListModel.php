<?php

namespace App\Src\Brand\Infra\Eloquent;

use App\Src\Category\Infra\Eloquent\CategoryModel;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSignListModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_sign_list';

    protected $dates = [
        'order_sign_time'
    ];

    protected $fillable = [
        'brand_id',
        'loupan_id',
        'province_id',
        'city_id',
        'product_model',
        'brand_total_amount',
        'delivery_num',
        'order_sign_time',
        'status',
    ];

    public function brand_sign_categorys()
    {
        return $this->belongsToMany(CategoryModel::class, 'brand_sign_list_category', 'project_sign_id', 'category_id')->withTimestamps();
    }

    public function project_developers()
    {
        return $this->belongsToMany(DeveloperModel::class, 'brand_sign_developer', 'project_sign_id', 'developer_id')->withTimestamps();
    }
}