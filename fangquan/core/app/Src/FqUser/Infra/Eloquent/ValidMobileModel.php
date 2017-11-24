<?php

namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValidMobileModel extends Model
{
    use SoftDeletes;

    protected $table = 'valid_mobile';

    protected $dates = ['expire'];

    protected $fillable = [
        'mobile',
        'verifycode',
        'expire',
    ];

}