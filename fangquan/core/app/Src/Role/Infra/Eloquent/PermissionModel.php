<?php namespace App\Src\Role\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionModel extends Model
{
    use SoftDeletes;

    protected $table = 'permission';

    protected $fillable = [
        'name',
        'desc',
    ];

}