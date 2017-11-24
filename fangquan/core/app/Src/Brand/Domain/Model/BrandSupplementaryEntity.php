<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Brand\Infra\Eloquent\BrandCategoryModel;
use Carbon\Carbon;

class BrandSupplementaryEntity extends Entity
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
     * @var string
     */
    public $desc;

    /**
     * @var array
     */
    public $supplementary_files;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                  => $this->id,
            'desc'                => $this->desc,
            'brand_id'            => $this->brand_id,
            'supplementary_files' => $this->supplementary_files,
            'created_at'          => $this->created_at->toDateTimeString(),
            'updated_at'          => $this->updated_at->toDateTimeString(),
        ];
    }
}