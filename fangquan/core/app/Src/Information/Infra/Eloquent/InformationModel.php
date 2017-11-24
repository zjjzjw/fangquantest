<?php

namespace App\Src\Information\Infra\Eloquent;

use App\Src\Category\Infra\Eloquent\CategoryModel;
use App\Src\Provider\Infra\Eloquent\ProviderModel;
use App\Src\Theme\Infra\Eloquent\ThemeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationModel extends Model
{
    use SoftDeletes;

    protected $table = 'information';

    protected $dates = [
        'publish_at',
    ];

    protected $fillable = [
        'title',
        'thumbnail',
        'publish_at',
        'tag_id',
        'comment_count',
        'content',
        'order',
        'status',
        'author',
        'created_user_id',
        'product_id',
        'is_publish',
    ];

    public function information_brands()
    {
        return $this->belongsToMany(ProviderModel::class, 'information_brand', 'information_id', 'brand_id')->withTimestamps();
    }

    public function information_categorys()
    {
        return $this->belongsToMany(CategoryModel::class, 'information_category', 'information_id', 'category_id')->withTimestamps();
    }

    public function information_themes()
    {
        return $this->belongsToMany(ThemeModel::class, 'information_theme', 'information_id', 'theme_id')->withTimestamps();
    }

}