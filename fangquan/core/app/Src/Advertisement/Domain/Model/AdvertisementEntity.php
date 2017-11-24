<?php namespace App\Src\Advertisement\Domain\Model;

use App\Foundation\Domain\Entity;

class AdvertisementEntity extends Entity
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
     * @var int
     */
    public $image_id;

    /**
     * @var int
     */
    public $position;

    /**
     * @var int
     */
    public $type;

    /**
     * @var string
     */
    public $link;

    /**
     * @var int
     */
    public $sort;

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
            'title'      => $this->title,
            'image_id'   => $this->image_id,
            'position'   => $this->position,
            'sort'       => $this->sort,
            'type'       => $this->type,
            'link'       => $this->link,
            'status'     => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}