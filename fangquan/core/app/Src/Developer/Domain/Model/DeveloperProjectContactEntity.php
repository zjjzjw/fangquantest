<?php namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Entity;

class DeveloperProjectContactEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var int
     */
    public $developer_project_id;

    /**
     * @var int
     */
    public $type;

    /**
     * @var int
     */
    public $sort;

    /**
     * @var string
     */
    public $company_name;

    /**
     * @var string
     */
    public $contact_name;

    /**
     * @var string
     */
    public $job;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $telphone;

    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string
     */
    public $remark;

    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                   => $this->id,
            'developer_project_id' => $this->developer_project_id,
            'type'                 => $this->type,
            'sort'                 => $this->sort,
            'company_name'         => $this->company_name,
            'contact_name'         => $this->contact_name,
            'job'                  => $this->job,
            'address'              => $this->address,
            'telphone'             => $this->telphone,
            'mobile'               => $this->mobile,
            'remark'               => $this->remark,
            'created_at'           => $this->created_at->toDateTimeString(),
            'updated_at'           => $this->updated_at->toDateTimeString(),
        ];
    }
}