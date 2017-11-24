<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleChannelModel extends Model
{
    use SoftDeletes;

    protected $table = 'sale_channel';

    protected $dates = [

    ];

    protected $fillable = [
        'brand_id',
        'sale_year',
        'channel_type',
        'sale_volume',
    ];

}