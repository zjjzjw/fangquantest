<?php

namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FqUserModel extends Model
{
    use SoftDeletes;

    protected $table = 'fq_user';

    protected $dates = ['reg_time'];

    protected $fillable = [
        'nickname',
        'mobile',
        'email',
        'account',
        'account_type',
        'role_type',
        'role_id',
        'platform_id',
        'register_type_id',
        'salt',
        'password',
        'avatar',
        'project_area',
        'project_category',
        'admin_id',
        'reg_time',
        'expire',
        'status',
    ];

    /**
     * 加密密码密码
     * @param $password
     * @param $salt
     * @return string
     */
    public function getMd5PasswordAndSalt($password, $salt)
    {
        return md5(md5($password) . $salt);
    }

    /**
     * 生成加密随机数
     * @return string
     */
    public function generateSalt()
    {
        return (String)random_int(100000, 999999);
    }

}