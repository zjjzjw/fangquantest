<?php namespace App\Src\Content\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserAnswerModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_answer';

    protected $fillable = [
        'user_id',
        'answer',
    ];
}