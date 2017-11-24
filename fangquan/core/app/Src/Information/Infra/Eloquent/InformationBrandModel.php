<?php

namespace App\Src\Information\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationBrandModel extends Model
{
    use SoftDeletes;

    protected $table = 'information_brand';

    protected $fillable = [
        'information_id',
        'brand_id',
    ];

}