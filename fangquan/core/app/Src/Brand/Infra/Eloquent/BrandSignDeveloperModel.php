<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSignDeveloperModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_sign_developer';

    protected $fillable = [
        'project_sign_id',
        'developer_id',
        'developer_name',
    ];
}