<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceModelModel extends Model
{
    use SoftDeletes;

    protected $table = 'service_model';

    protected $fillable = [
        'service_id',
        'model_type',
    ];

    public function brand_service()
    {
        return $this->belongsTo(BrandServiceModel::class, 'service_id', 'id');
    }
}