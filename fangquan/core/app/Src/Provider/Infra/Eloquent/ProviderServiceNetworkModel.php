<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderServiceNetworkModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_service_network';

    protected $fillable = [
        'name',
        'provider_id',
        'province_id',
        'city_id',
        'address',
        'worker_count',
        'contact',
        'telphone',
        'status',
    ];
}