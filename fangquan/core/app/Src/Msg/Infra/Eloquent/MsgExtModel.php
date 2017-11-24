<?php
namespace App\Src\Msg\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MsgExtModel extends Model
{
    use SoftDeletes;

    protected $table = 'msg_ext';

    protected $dates = [
    ];

    protected $fillable = [
        'content',
        'msg_type',
    ];
}