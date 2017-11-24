<?php
namespace App\Src\Msg\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BroadcastMsgModel extends Model
{
    use SoftDeletes;

    protected $table = 'broadcast_msg';

    protected $dates = [
    ];

    protected $fillable = [
        'form_uid',
        'msg_id',
        'msg_type',
        'status',
    ];
}