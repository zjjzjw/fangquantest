<?php
namespace App\Src\Surport\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    public $timestamps = false;

    protected $table = 'city';

    protected $fillable = [
        'name',
        'province_id',
    ];
}