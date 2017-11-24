<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_product';

    protected $fillable = [
        'provider_id',
        'product_category_id',
        'name',
        'views',
        'attrib',
        'attrib_integrity',
        'price_low',
        'price_high',
        'status',
    ];

    public function provider_product_pictures()
    {
        return $this->hasMany(ProviderProductPictureModel::class, 'provider_product_id', 'id');
    }


}