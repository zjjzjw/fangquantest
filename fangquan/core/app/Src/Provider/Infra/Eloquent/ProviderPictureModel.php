<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderPictureModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_picture';


    protected $fillable = [
        'provider_id',
        'type',
        'image_id',
    ];


}