<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Src\Brand\Infra\Eloquent\ServiceModelModel;

class BrandServiceModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_service';

    protected $dates = [

    ];

    protected $fillable = [
        'brand_id',
        'service_range',
        'warranty_range',
        'supply_cycle',
    ];

    public function service_models()
    {
        return $this->hasMany(ServiceModelModel::class, 'service_id', 'id');
    }

    public function service_charts()
    {
        return $this->hasMany(ServiceChartModel::class, 'service_id', 'id');
    }
}