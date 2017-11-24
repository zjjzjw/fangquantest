<?php

namespace App\Src\Brand\Domain\Model;


use App\Foundation\Domain\Entity;
use App\Src\Brand\Infra\Eloquent\BrandCategoryModel;
use Carbon\Carbon;

class BrandCertificateEntity extends Entity
{

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $brand_id;

    /**
     * @var int
     */
    public $type;

    /**
     * @var int
     */
    public $certificate_file;

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
            'id'               => $this->id,
            'name'             => $this->name,
            'brand_id'         => $this->brand_id,
            'type'             => $this->type,
            'certificate_file' => $this->certificate_file,
            'status'           => $this->status,
            'created_at'       => $this->created_at->toDateTimeString(),
            'updated_at'       => $this->updated_at->toDateTimeString(),
        ];
    }
}