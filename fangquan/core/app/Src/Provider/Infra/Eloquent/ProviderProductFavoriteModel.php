<?php

namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderProductFavoriteModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_product_favorite';

    protected $fillable = [
        'user_id',
        'provider_product_id',
    ];

}