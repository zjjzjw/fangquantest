<?php namespace App\Src\Provider\Infra\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderPropagandaModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_propaganda';

    protected $fillable = [
        'provider_id',
        'image_id',
        'link',
        'status',
    ];

}