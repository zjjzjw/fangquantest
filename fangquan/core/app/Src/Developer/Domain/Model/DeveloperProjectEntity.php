<?php namespace App\Src\Developer\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class DeveloperProjectEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';
    /**
     * @var Carbon
     */
    public $name;

    /**
     * @var Carbon
     */
    public $time;

    /**
     * @var int
     */
    public $developer_id;

    /**
     * @var int
     */
    public $project_stage_id;

    /**
     * 是否优选 1=是 2=否
     * @var int
     */
    public $is_great;

    /**
     * 开发商类型 1=百强开发商 2=普通开发商
     * @var int
     */
    public $developer_type;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var string
     */
    public $address;

    /**
     * @var int
     */
    public $cost;

    /**
     * @var int
     */
    public $views;

    /**
     * 项目类型
     * @var int
     */
    public $type;

    /**
     * 项目类别
     * @var int
     */
    public $project_category;

    /**
     * @var Carbon
     */
    public $time_start;

    /**
     * @var Carbon
     */
    public $time_end;

    /**
     * @var int
     */
    public $stage_design;

    /**
     * @var int
     */
    public $stage_build;

    /**
     * @var int
     */
    public $stage_decorate;

    /**
     * @var int
     */
    public $floor_space;

    /**
     * @var int
     */
    public $floor_numbers;

    /**
     * @var int
     */
    public $investments;

    /**
     * @var string
     */
    public $heating_mode;

    /**
     * @var string
     */
    public $wall_materials;

    /**
     * @var int
     */
    public $has_decorate;

    /**
     * @var int
     */
    public $has_airconditioner;

    /**
     * @var int
     */
    public $has_steel;

    /**
     * @var int
     */
    public $has_elevator;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $is_ad;

    /**
     * @var int
     */
    public $source;

    /**
     * 项目产品分类
     * @var array
     */
    public $developer_project_category;

    /**
     * @var string
     */
    public $other;

    /**
     * @var string
     */
    public $area;

    /**
     * @var string
     */
    public $contacts;

    /**
     * @var string
     */
    public $contacts_phone;

    /**
     * @var string
     */
    public $contacts_address;

    /**
     * @var string
     */
    public $contacts_email;

    /**
     * 项目类别
     * @var array
     */
    public $project_categories;

    /**
     * 项目项目分类
     * @var array
     */
    public $project_category_ids;

    /*
     * @var int
     */
    public $bidding_type;

    /**
     * @var string
     */
    public $deadline_for_registration;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                         => $this->id,
            'time'                       => $this->time->toDateTimeString(),
            'name'                       => $this->name,
            'developer_id'               => $this->developer_id,
            'project_stage_id'           => $this->project_stage_id,
            'is_great'                   => $this->is_great,
            'developer_type'             => $this->developer_type,
            'province_id'                => $this->province_id,
            'city_id'                    => $this->city_id,
            'address'                    => $this->address,
            'cost'                       => $this->cost,
            'views'                      => $this->views,
            'type'                       => $this->type,
            'project_category'           => $this->project_category,
            'time_start'                 => $this->time_start->toDateTimeString(),
            'time_end'                   => $this->time_end->toDateTimeString(),
            'stage_design'               => $this->stage_design,
            'stage_build'                => $this->stage_build,
            'stage_decorate'             => $this->stage_decorate,
            'floor_space'                => $this->floor_space,
            'floor_numbers'              => $this->floor_numbers,
            'investments'                => $this->investments,
            'heating_mode'               => $this->heating_mode,
            'wall_materials'             => $this->wall_materials,
            'has_decorate'               => $this->has_decorate,
            'has_airconditioner'         => $this->has_airconditioner,
            'has_steel'                  => $this->has_steel,
            'has_elevator'               => $this->has_elevator,
            'summary'                    => $this->summary,
            'source'                     => $this->source,
            'status'                     => $this->status,
            'is_ad'                      => $this->is_ad,
            'other'                      => $this->other,
            'area'                       => $this->area,
            'contacts'                   => $this->contacts,
            'contacts_phone'             => $this->contacts_phone,
            'contacts_address'           => $this->contacts_address,
            'contacts_email'             => $this->contacts_email,
            'project_categories'         => $this->project_categories,
            'developer_project_category' => $this->developer_project_category,
            'project_category_ids'       => $this->project_category_ids,
            'bidding_type'               => $this->bidding_type,
            'deadline_for_registration'  => $this->deadline_for_registration,
            'created_at'                 => $this->created_at->toDateTimeString(),
            'updated_at'                 => $this->updated_at->toDateTimeString(),
        ];
    }
}