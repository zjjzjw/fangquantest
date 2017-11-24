<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderProjectPictureModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_project_picture';

    protected $fillable = [
        'provider_project_id',
        'image_id',
    ];
}