<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSaleModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_sale';

    protected $dates = [

    ];

    protected $fillable = [
        'name',
        'brand_id',
        'type',
        'telphone',
        'status',
    ];

    public function sale_areas()
    {
        return $this->hasMany(BrandSaleAreaModel::class, 'brand_sale_id', 'id');
    }
}