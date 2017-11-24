<?php
namespace App\Src\Surport\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ChinaAreaModel extends Model
{

    public $timestamps = false;

    protected $table = 'china_area';

    protected $fillable = [
        'name',
    ];
}