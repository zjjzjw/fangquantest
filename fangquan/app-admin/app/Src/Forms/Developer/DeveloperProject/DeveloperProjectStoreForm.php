<?php

namespace App\Admin\Src\Forms\Developer\DeveloperProject;


use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperProjectEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;
use Carbon\Carbon;

class DeveloperProjectStoreForm extends Form
{
    /**
     * @var DeveloperProjectEntity
     */
    public $developer_project_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                         => 'required|integer',
            'name'                       => 'required|string',
            'time'                       => 'date_format:Y-m-d H:i:s',
            'developer_id'               => 'required|integer',
            'project_stage_id'           => 'required|integer',
            'developer_type'             => 'integer',
            'province_id'                => 'required|integer',
            'city_id'                    => 'required|integer',
            'address'                    => 'required|string',
            'cost'                       => 'integer',
            'views'                      => 'integer',
            'type'                       => 'integer',
            'project_category'           => 'integer',
            'time_start'                 => 'date_format:Y-m-d H:i:s',
            'time_end'                   => 'date_format:Y-m-d H:i:s',
            'stage_design'               => 'integer',
            'stage_build'                => 'integer',
            'stage_decorate'             => 'integer',
            'floor_space'                => 'integer',
            'floor_numbers'              => 'integer',
            'investments'                => 'integer',
            'heating_mode'               => 'string',
            'wall_materials'             => 'string',
            'has_decorate'               => 'integer',
            'has_airconditioner'         => 'integer',
            'has_steel'                  => 'integer',
            'has_elevator'               => 'integer',
            'summary'                    => 'string',
            'status'                     => 'required|integer',
            'source'                     => 'integer',
            'is_ad'                      => 'required|integer',
            'developer_project_category' => 'nullable|string',
            'area'                       => 'string',
            'other'                      => 'string',
            'contacts'                   => 'string',
            'contacts_phone'             => 'string',
            'contacts_address'           => 'string',
            'contacts_email'             => 'string',
            'project_categories'         => 'array',
            'project_category_ids'       => 'nullable|string',
            'bidding_type'               => 'nullable|integer',
            'deadline_for_registration'  => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function attributes()
    {
        return [
            'id'                         => '标识',
            'name'                       => '项目名称',
            'time'                       => '发布时间',
            'developer_id'               => '开发商',
            'project_stage_id'           => '项目阶段',
            'is_great'                   => '优选',
            'developer_type'             => '开发商类型',
            'province_id'                => '省份',
            'city_id'                    => '城市',
            'address'                    => '地址',
            'cost'                       => '造价',
            'views'                      => '浏览数',
            'type'                       => '项目类型',
            'project_category'           => '项目类别',
            'time_start'                 => '开始时间',
            'time_end'                   => '结束时间',
            'stage_design'               => '设计阶段',
            'stage_build'                => '施工阶段',
            'stage_decorate'             => '装修阶段',
            'floor_space'                => '建筑面积',
            'floor_numbers'              => '建筑层数',
            'investments'                => '总投资额',
            'heating_mode'               => '供暖方式',
            'wall_materials'             => '外墙材料',
            'has_decorate'               => '是否精装修',
            'has_airconditioner'         => '有无空调',
            'has_steel'                  => '有无钢结构',
            'has_elevator'               => '有无电梯',
            'summary'                    => '概况',
            'status'                     => '状态',
            'source'                     => '数据来源',
            'is_ad'                      => '是否广告',
            'developer_project_category' => '分类',
            'area'                       => '区域',
            'other'                      => '其他',
            'contacts'                   => '联系人',
            'contacts_phone'             => '联系人电话',
            'contacts_address'           => '联系人地址',
            'contacts_email'             => '联系人邮箱',
            'project_category_ids'       => '项目类别',
        ];
    }

    public function validation()
    {
        if (array_get($this->data, 'id')) {
            $developer_project_repository = new DeveloperProjectRepository();
            /** @var DeveloperProjectEntity $developer_project_entity */
            $developer_project_entity = $developer_project_repository->fetch(array_get($this->data, 'id'));
        } else {
            $developer_project_entity = new DeveloperProjectEntity();
            $developer_project_entity->time = Carbon::now()->toDateTimeString();
            $developer_project_entity->views = 0;
            $developer_project_entity->project_category = 0;
        }
        $developer_project_entity->name = array_get($this->data, 'name');
        $developer_project_entity->developer_id = array_get($this->data, 'developer_id');
        $developer_project_entity->project_stage_id = array_get($this->data, 'project_stage_id');
        $developer_project_entity->is_great = array_get($this->data, 'is_great') ?? 0;
        $developer_project_entity->developer_type = array_get($this->data, 'developer_type', 1);
        $developer_project_entity->province_id = array_get($this->data, 'province_id');
        $developer_project_entity->city_id = array_get($this->data, 'city_id');
        $developer_project_entity->address = array_get($this->data, 'address');
        $developer_project_entity->cost = array_get($this->data, 'cost');
        $developer_project_entity->type = array_get($this->data, 'type');
        $developer_project_entity->time_start = array_get($this->data, 'time_start');
        $developer_project_entity->time_end = array_get($this->data, 'time_end');
        $developer_project_entity->time_end = array_get($this->data, 'time_end');
        $developer_project_entity->stage_design = array_get($this->data, 'stage_design');
        $developer_project_entity->stage_build = array_get($this->data, 'stage_build');
        $developer_project_entity->stage_decorate = array_get($this->data, 'stage_decorate');
        $developer_project_entity->floor_space = array_get($this->data, 'floor_space');
        $developer_project_entity->floor_numbers = array_get($this->data, 'floor_numbers');
        $developer_project_entity->investments = array_get($this->data, 'investments');
        $developer_project_entity->heating_mode = array_get($this->data, 'heating_mode');
        $developer_project_entity->wall_materials = array_get($this->data, 'wall_materials');
        $developer_project_entity->has_decorate = array_get($this->data, 'has_decorate');
        $developer_project_entity->has_airconditioner = array_get($this->data, 'has_airconditioner');
        $developer_project_entity->has_steel = array_get($this->data, 'has_steel');
        $developer_project_entity->has_elevator = array_get($this->data, 'has_elevator');
        $developer_project_entity->summary = array_get($this->data, 'summary');
        $developer_project_entity->status = array_get($this->data, 'status');
        $developer_project_entity->is_ad = array_get($this->data, 'is_ad');
        $developer_project_entity->area = array_get($this->data, 'area');
        $developer_project_entity->other = array_get($this->data, 'other');
        $developer_project_entity->contacts = array_get($this->data, 'contacts');
        $developer_project_entity->contacts_address = array_get($this->data, 'contacts_address');
        $developer_project_entity->contacts_email = array_get($this->data, 'contacts_email');
        $developer_project_entity->contacts_phone = array_get($this->data, 'contacts_phone');
        $developer_project_entity->source = array_get($this->data, 'source', 0);
        $developer_project_entity->project_categories = array_get($this->data, 'project_categories');
        $developer_project_category = array_get($this->data, 'developer_project_category');
        if ($developer_project_category) {
            $developer_project_entity->developer_project_category = explode(',', $developer_project_category);
        } else {
            $developer_project_entity->developer_project_category = [];
        }
        $project_category_ids = array_get($this->data, 'project_category_ids');
        if ($project_category_ids) {
            $developer_project_entity->project_category_ids = explode(',', $project_category_ids);
        } else {
            $developer_project_entity->project_category_ids = [];
        }


        $developer_project_entity->bidding_type = array_get($this->data, 'bidding_type') ?? 0;
        $developer_project_entity->deadline_for_registration = array_get($this->data, 'deadline_for_registration') ?? '';


        $this->developer_project_entity = $developer_project_entity;

    }

}