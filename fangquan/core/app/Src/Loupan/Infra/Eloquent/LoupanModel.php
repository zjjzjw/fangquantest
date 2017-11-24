<?php namespace App\Src\Loupan\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;

class LoupanModel extends Model
{
    use SoftDeletes;

    protected $table = 'loupan';

    protected $fillable = [
        'name',
        'province_id',
        'city_id',
    ];

    public function loupan_developers()
    {
        return $this->belongsToMany(DeveloperModel::class, 'loupan_developer', 'loupan_id', 'developer_id')->withTimestamps();
    }
}