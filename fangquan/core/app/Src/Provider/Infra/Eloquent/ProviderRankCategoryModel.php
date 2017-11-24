<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderRankCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_rank_category';

    protected $fillable = [
        'title',
        'category_id',
        'rank',
        'provider_id',
    ];


}