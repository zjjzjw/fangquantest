<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductProgrammeFavoriteModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_programme_favorite';

    protected $fillable = [
        'user_id',
        'product_programme_id',
    ];

}