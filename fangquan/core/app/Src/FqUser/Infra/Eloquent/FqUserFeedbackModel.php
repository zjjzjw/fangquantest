<?php

namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FqUserFeedbackModel extends Model
{
    use SoftDeletes;

    protected $table = 'fq_user_feedback';

    protected $fillable = [
        'fq_user_id',
        'image_id',
        'contact',
        'device',
        'appver',
        'content',
        'status',
    ];

}