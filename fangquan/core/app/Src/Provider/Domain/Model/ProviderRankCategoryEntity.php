<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderRankCategoryEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

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
    public $category_id;

    /**
     * @var int
     */
    public $rank;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'          => $this->id,
            'provider_id' => $this->provider_id,
            'title'       => $this->title,
            'category_id' => $this->category_id,
            'rank'        => $this->rank,
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }

}