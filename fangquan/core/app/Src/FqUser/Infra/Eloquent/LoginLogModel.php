<?php

namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginLogModel extends Model
{
    use SoftDeletes;

    protected $table = 'login_log';

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'ip',
    ];

}