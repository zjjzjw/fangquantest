<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSupplementaryFileModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_supplementary_file';

    protected $dates = [

    ];

    protected $fillable = [
        'file_id',
        'brand_supplementary_id',
    ];
}