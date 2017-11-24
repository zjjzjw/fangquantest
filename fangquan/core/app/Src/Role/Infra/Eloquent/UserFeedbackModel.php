<?php namespace App\Src\Role\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserFeedbackModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_feedback';

    protected $fillable = [
        'user_id',
        'contact',
        'content',
    ];
}