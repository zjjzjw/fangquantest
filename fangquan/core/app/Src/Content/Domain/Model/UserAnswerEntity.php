<?php namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class UserAnswerEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $user_id;

    /**
     * @var string
     */
    public $answer;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'answer'     => $this->answer,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}