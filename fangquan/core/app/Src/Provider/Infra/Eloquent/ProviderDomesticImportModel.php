<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderDomesticImportModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_domestic_import';

    protected $fillable = [
        'provider_id',
        'domestic_import_id',
    ];
}