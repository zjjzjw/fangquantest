<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderMainCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_main_category';


    protected $fillable = [
        'provider_id',
        'product_category_id',
    ];


}