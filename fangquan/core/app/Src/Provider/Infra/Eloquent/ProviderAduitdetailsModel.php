<?php namespace App\Src\Provider\Infra\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderAduitdetailsModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_aduitdetails';

    protected $fillable = [
        'provider_id',
        'type',
        'name',
        'link',
        'filename',
        'created_at',
        'deleted_at'
    ];

}