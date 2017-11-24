<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderCertificateModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_certificate';

    protected $fillable = [
        'provider_id',
        'name',
        'image_id',
        'type',
        'status',
    ];

}