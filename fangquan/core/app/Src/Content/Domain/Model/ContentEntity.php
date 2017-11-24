<?php namespace App\Src\Content\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ContentEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $author;

    /**
     * @var string
     */
    public $url;

    /**
     * @var integer
     */
    public $audio;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $remake;

    /**
     * @var int
     */
    public $type;

    /**
     * @var Carbon
     */
    public $publish_time;

    /**
     * @var int
     */
    public $is_timing_publish;

    /**
     * @var int
     */
    public $status;

    /**
     * @var array
     */
    public $content_images;

    /**
     * @var string
     */
    public $audio_title;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'author'            => $this->author,
            'url'               => $this->url,
            'audio'             => $this->audio,
            'content'           => $this->content,
            'remake'            => $this->remake,
            'type'              => $this->type,
            'is_timing_publish' => $this->is_timing_publish,
            'publish_time'      => $this->publish_time->toDateTimeString(),
            'status'            => $this->status,
            'audio_title'       => $this->audio_title,
            'content_images'    => $this->content_images,
            'created_at'        => $this->created_at->toDateTimeString(),
            'updated_at'        => $this->updated_at->toDateTimeString(),
        ];
    }
}