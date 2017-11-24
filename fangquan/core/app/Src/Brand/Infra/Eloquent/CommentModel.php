<?php

namespace App\Src\Brand\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentModel extends Model
{
    use SoftDeletes;

    protected $table = 'comment';

    protected $fillable = [
        'user_id',
        'type',
        'content',
        'created_user_id',
        'p_id',
    ];

}