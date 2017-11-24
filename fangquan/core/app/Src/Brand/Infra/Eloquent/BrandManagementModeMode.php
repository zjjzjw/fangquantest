<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandManagementModeMode extends Model
{
    use SoftDeletes;

    protected $table = 'brand_management_mode';

    protected $fillable = [
        'brand_id',
        'management_mode_type',
    ];

}