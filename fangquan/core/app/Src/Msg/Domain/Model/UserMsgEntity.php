<?php
namespace App\Src\Msg\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class UserMsgEntity extends Entity
{
    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $msg_id;

    /**
     * @var int
     */
    public $from_uid;

    /**
     * @var int
     */
    public $to_uid;

    /**
     * @var int
     */
    public $msg_type;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $content;

    /**
     * @var Carbon
     */
    public $read_at;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'msg_id'     => $this->msg_id,
            'from_uid'   => $this->from_uid,
            'to_uid'     => $this->to_uid,
            'msg_type'   => $this->msg_type,
            'status'     => $this->status,
            'content'    => $this->content,
            'read_at'    => $this->read_at->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}