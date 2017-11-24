<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderProductProgrammePictureModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_product_programme_picture';

    protected $fillable = [
        'programme_id',
        'image_id',
    ];

}