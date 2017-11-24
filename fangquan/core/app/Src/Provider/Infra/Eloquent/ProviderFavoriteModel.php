<?php

namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderFavoriteModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_favorite';

    protected $fillable = [
        'user_id',
        'provider_id',
    ];

}