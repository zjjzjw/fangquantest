<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Brand\Infra\Eloquent\BrandCategoryModel;
use Carbon\Carbon;

class BrandCooperationEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $brand_id;

    /**
     * @var int
     */
    public $developer_id;

    /**
     * @var string
     */
    public $developer_name;

    /**
     * @var string
     */
    public $deadline;

    /**
     * @var string
     */
    public $is_exclusive;

    /**
     * @var int
     */
    public $status;

    /**
     * @var array
     */
    public $brand_cooperation_categorys;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                          => $this->id,
            'developer_id'                => $this->developer_id,
            'developer_name'              => $this->developer_name,
            'brand_id'                    => $this->brand_id,
            'deadline'                    => $this->deadline,
            'is_exclusive'                => $this->is_exclusive,
            'status'                      => $this->status,
            'brand_cooperation_categorys' => $this->brand_cooperation_categorys,
            'created_at'                  => $this->created_at->toDateTimeString(),
            'updated_at'                  => $this->updated_at->toDateTimeString(),
        ];
    }
}