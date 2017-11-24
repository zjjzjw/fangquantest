<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderProductPictureModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_product_picture';

    protected $fillable = [
        'provider_product_id',
        'image_id',
    ];

    public function provider_product()
    {
        $this->belongsTo(ProviderProductModel::class, 'provider_product_id', 'id');
    }

}