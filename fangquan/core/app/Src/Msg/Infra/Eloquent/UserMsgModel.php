<?php
namespace App\Src\Msg\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMsgModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_msg';

    protected $dates = [
        'read_at',
    ];

    protected $fillable = [
        'msg_id',
        'from_uid',
        'to_uid',
        'msg_type',
        'read_at',
        'status',
    ];


    public function msg_ext()
    {
        return $this->belongsTo(MsgExtModel::class, 'msg_id', 'id');
    }
}