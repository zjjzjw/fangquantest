<?php

namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThirdPartyBindModel extends Model
{
    use SoftDeletes;

    protected $table = 'third_party_bind';

    protected $fillable = [
        'third_type',
        'open_id',
        'user_id',
    ];

}