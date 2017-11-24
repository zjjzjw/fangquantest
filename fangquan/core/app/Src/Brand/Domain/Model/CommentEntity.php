<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class CommentEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $type;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var int
     */
    public $p_id;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'type'            => $this->type,
            'content'         => $this->content,
            'created_user_id' => $this->created_user_id,
            'p_id'            => $this->p_id,
            'created_at'      => $this->created_at->toDateTimeString(),
            'updated_at'      => $this->updated_at->toDateTimeString(),
        ];
    }
}