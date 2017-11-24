<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandSupplementaryModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_supplementary';

    protected $dates = [

    ];

    protected $fillable = [
        'brand_id',
        'desc',
    ];

    public function supplementary_files()
    {
        return $this->hasMany(BrandSupplementaryFileModel::class, 'brand_supplementary_id', 'id');
    }
}