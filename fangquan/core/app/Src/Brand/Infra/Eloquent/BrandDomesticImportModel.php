<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandDomesticImportModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_domestic_import';

    protected $fillable = [
        'brand_id',
        'domestic_import_id',
    ];

}