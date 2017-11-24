<?php namespace App\Src\MediaManagement\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MediaManagementModel extends Model
{
    use SoftDeletes;

    protected $table = 'media_management';

    protected $fillable = [
        'name',
        'logo',
        'type',
    ];
}