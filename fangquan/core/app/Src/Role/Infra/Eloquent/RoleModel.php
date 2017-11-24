<?php namespace App\Src\Role\Infra\Eloquent;

use App\Src\FqUser\Infra\Eloquent\FqUserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model
{
    use SoftDeletes;

    protected $table = 'role';

    protected $fillable = [
        'name',
        'desc',
    ];

    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, 'role_permission', 'role_id', 'permission_id')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(FqUserModel::class, 'user_role', 'role_id', 'user_id')->withTimestamps();
    }


}