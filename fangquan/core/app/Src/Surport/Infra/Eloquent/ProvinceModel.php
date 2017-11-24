<?php
namespace App\Src\Surport\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    public $timestamps = false;

    protected $table = 'province';

    protected $fillable = [
        'name',
        'area_id',
    ];
}