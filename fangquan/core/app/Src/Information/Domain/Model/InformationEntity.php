<?php

namespace App\Src\Information\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Information\Infra\Eloquent\InformationBrandModel;
use App\Src\Information\Infra\Eloquent\InformationCategoryModel;
use App\Src\Information\Infra\Eloquent\InformationProductModel;
use App\Src\Information\Infra\Eloquent\InformationThemeModel;
use Carbon\Carbon;

class InformationEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $thumbnail;

    /**
     * @var Carbon
     */
    public $publish_at;


    /**
     * @var int
     */
    public $tag_id;

    /**
     * @var string
     */
    public $content;

    /**
     * @var int
     */
    public $order;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $author;

    /**
     * @var int
     */
    public $created_user_id;

    /**
     * @var array
     */
    public $information_brands;

    /**
     * @var array
     */
    public $information_categorys;

    /**
     * @var array
     */
    public $information_themes;

    /**
     * @var array
     */
    public $information_brands_info;

    /**
     * @var int
     */
    public $product_id;

    /**
     * @var int
     */
    public $comment_count;

    /**
     * @var int
     */
    public $is_publish;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'thumbnail'             => $this->thumbnail,
            'publish_at'            => $this->publish_at->toDateTimeString(),
            'tag_id'                => $this->tag_id,
            'content'               => $this->content,
            'order'                 => $this->order,
            'status'                => $this->status,
            'author'                => $this->author,
            'created_user_id'       => $this->created_user_id,
            'information_brands'    => $this->information_brands,
            'information_categorys' => $this->information_categorys,
            'information_themes'    => $this->information_themes,
            'product_id'            => $this->product_id,
            'comment_count'         => $this->comment_count,
            'is_publish'            => $this->is_publish,
            'created_at'            => $this->created_at->toDateTimeString(),
            'updated_at'            => $this->updated_at->toDateTimeString(),
        ];
    }
}