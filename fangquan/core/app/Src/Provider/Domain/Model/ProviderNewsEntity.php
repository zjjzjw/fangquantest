<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderNewsEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $provider_id;
    /**
     * @var string
     */
    public $title;
    /**
     * @var int
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
            'id'          => $this->id,
            'provider_id' => $this->provider_id,
            'title'       => $this->title,
            'content'     => $this->content,
            'status'      => $this->status,
            'created_at'  => $this->created_at->toDateTimeString(),
            'update_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}