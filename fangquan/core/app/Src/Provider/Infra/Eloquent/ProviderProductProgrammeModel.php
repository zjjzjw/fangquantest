<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderProductProgrammeModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_product_programme';

    protected $fillable = [
        'title',
        'desc',
        'status',
        'provider_id',
    ];

    public function product()
    {
        return $this->belongsToMany(ProviderProductModel::class, 'product_programme', 'programme_id', 'product_id')->withTimestamps();
    }

    public function provider_product_programme_pictures()
    {
        return $this->hasMany(ProviderProductProgrammePictureModel::class, 'programme_id', 'id');
    }
}