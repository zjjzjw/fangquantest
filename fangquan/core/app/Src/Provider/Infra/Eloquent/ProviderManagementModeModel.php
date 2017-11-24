<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderManagementModeModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_management_mode';

    protected $fillable = [
        'provider_id',
        'management_mode_type',
    ];
}