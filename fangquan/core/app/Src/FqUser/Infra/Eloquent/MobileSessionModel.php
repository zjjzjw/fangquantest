<?php

namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobileSessionModel extends Model
{
    use SoftDeletes;

    protected $table = 'mobile_session';

    protected $fillable = [
        'user_id',
        'token',
        'reg_id',
        'type',
        'enable_notify',
    ];

}