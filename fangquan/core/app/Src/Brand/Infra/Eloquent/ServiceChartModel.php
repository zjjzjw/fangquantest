<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceChartModel extends Model
{
    use SoftDeletes;

    protected $table = 'service_chart';

    protected $fillable = [
        'service_id',
        'image_id',
    ];

    public function service_models()
    {
        return $this->hasMany(ServiceModelModel::class, 'service_id', 'id');
    }
}