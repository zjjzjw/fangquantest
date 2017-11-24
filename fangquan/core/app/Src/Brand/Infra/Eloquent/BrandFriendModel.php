<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandFriendModel extends Model
{
    use SoftDeletes;

    protected $table = 'brand_friend';

    protected $fillable = [
        'brand_id',
        'brand_friend_id',
    ];

}