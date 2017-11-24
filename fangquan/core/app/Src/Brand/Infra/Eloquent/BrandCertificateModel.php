<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandCertificateModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_certificate';

    protected $dates = [

    ];

    protected $fillable = [
        'name',
        'brand_id',
        'type',
        'certificate_file',
        'status',
    ];
}