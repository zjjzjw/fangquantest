<?php namespace App\Src\Role\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermissionModel extends Model
{
    use SoftDeletes;

    protected $table = 'role_permission';

    protected $fillable = [
        'role_id',
        'permission_id',
    ];

}