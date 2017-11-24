<?php
namespace App\Src\Msg\Domain\Model;


use App\Foundation\Domain\Entity;

class MsgExtEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $msg_type;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'content'    => $this->content,
            'msg_type'   => $this->msg_type,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}