<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderProjectModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_project';

    protected $fillable = [
        'provider_id',
        'name',
        'developer_name',
        'province_id',
        'city_id',
        'time',
        'status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider_project_pictures()
    {
        return $this->hasMany(ProviderProjectPictureModel::class, 'provider_project_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider_project_products()
    {
        return $this->hasMany(ProviderProjectProductModel::class, 'provider_project_id', 'id');
    }
}