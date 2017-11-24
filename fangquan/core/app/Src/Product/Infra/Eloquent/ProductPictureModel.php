<?php

namespace App\Src\Product\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPictureModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_picture';

    protected $fillable = [
        'product_id',
        'image_id',
    ];

}