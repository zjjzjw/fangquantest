<?php namespace App\Src\Role\Infra\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use SoftDeletes;

    protected $table = 'user';

    protected $dates = [

    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'account',
        'company_id',
        'company_name',
        'employee_id',
        'position',
        'name',
        'email',
        'phone',
        'status',
        'type',
        'created_user_id',
    ];

    /**
     * 角色表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'user_role', 'user_id', 'role_id');
    }

    /**
     * 部门表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function departs()
    {
        return $this->belongsToMany(DepartModel::class, 'user_depart', 'user_id', 'depart_id');
    }

    /**
     * 生成密码
     * @param $password
     * @return string
     */
    public function getMd5Password($password)
    {
        return md5(md5($password) . config('auth.salt'));
    }
}