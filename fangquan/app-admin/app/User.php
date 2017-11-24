<?php

namespace App\Admin;

use App\Admin\Http\Middleware\RoleMiddleware;
use App\Src\Role\Infra\Eloquent\RoleModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    protected $table = 'fq_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'name', 'email', 'password',
        'nickname', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected static $permissions;

    /**
     * @return boolean
     */
    public function isSuperAdmin()
    {
        $super_phone = getenv('SUPERADMIN_PHONE');
        $phones = explode('|', $super_phone);
        if (in_array($this->mobile, $phones)) {
            return true;
        }
        return false;
    }

    public function hasPermission($route_name)
    {
        $bool = false;
        if ($this->isSuperAdmin()) {
            $bool = true;
        } else {
            $config_permissions = config('permissions');

            $codes = $config_permissions[$route_name];

            if (self::$permissions == null) {
                $permissions = collect();

                foreach ($this->roles as $role) {
                    foreach ($role->permissions as $permission) {
                        $permissions[] = $permission->toArray();
                    }
                }
                self::$permissions = $permissions;
            }

            $bool = self::$permissions->contains(function ($value) use ($codes) {
                if (is_array($codes)) {
                    return in_array($value['code'], $codes);
                } else {
                    return $value['code'] == $codes;
                }
            });
        }
        return $bool;
    }

    /**
     * 用户的角色
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'user_role', 'user_id', 'role_id');
    }

}
