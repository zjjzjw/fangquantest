<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderProjectProductModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_project_product';

    protected $fillable = [
        'provider_project_id',
        'name',
        'num',
        'measureunit_id',
    ];
}