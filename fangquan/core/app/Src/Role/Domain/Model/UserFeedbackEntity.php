<?php
namespace App\Src\Role\Domain\Model;

use Carbon\Carbon;
use App\Foundation\Domain\Entity;

class UserFeedbackEntity extends Entity
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
    public $contact;

    /**
     * @var string
     */
    public $content;


    public function __construct()
    {

    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'contact'    => $this->contact,
            'content'    => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}