<?php namespace App\Src\Content\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserInfoModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_info';

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'position',
        'phone',
        'email',
    ];
}