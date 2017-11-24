<?php namespace App\Src\FqUser\Domain\Model;

use App\Foundation\Domain\Entity;

class FqUserFeedbackEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $fq_user_id;
    /**
     * @var int
     */
    public $image_id;

    /**
     * @var string
     */
    public $contact;

    /**
     * @var string
     */
    public $device;

    /**
     * @var string
     */
    public $appver;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $status;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'         => $this->id,
            'fq_user_id' => $this->fq_user_id,
            'image_id'   => $this->image_id,
            'contact'    => $this->contact,
            'device'     => $this->device,
            'appver'     => $this->appver,
            'content'    => $this->content,
            'status'     => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}
