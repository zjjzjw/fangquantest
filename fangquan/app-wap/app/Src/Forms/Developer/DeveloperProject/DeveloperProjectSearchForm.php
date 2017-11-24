<?php

namespace App\Wap\Src\Forms\Developer\DeveloperProject;

use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Wap\Src\Forms\Form;

class DeveloperProjectSearchForm extends Form
{
    /**
     * @var DeveloperProjectSpecification
     */
    public $developer_project_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'             => 'nullable|string',
            'project_stage_id'    => 'nullable|integer',//项目阶段
            'area_id'             => 'nullable|integer',
            'province_id'         => 'nullable|integer',
            'is_great'            => 'nullable|integer',//是否优选 1=是 2=否
            'developer_type'      => 'nullable|integer',//开发商类型 1=百强开发商; 2=普通开发商
            'project_category'    => 'nullable|integer',//项目类别 1 - 住宅、2 - 酒店、3 - 工业、4 - 办公楼、5 - 商业综合体、6其它
            'page'                => 'nullable|integer',
            'status'              => 'required|integer',//项目状态
            'column'              => 'nullable|string',
            'sort'                => 'nullable|string',
            'is_add'              => 'nullable|integer',
            'product_category_id' => 'nullable|integer',
            'user_id'             => 'nullable|integer',
            'developer_id'        => 'nullable|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'keyword' => '关键字',
        ];
    }

    public function validation()
    {
        $this->developer_project_specification = new DeveloperProjectSpecification();
        $this->developer_project_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_project_specification->project_stage_id = array_get($this->data, 'project_stage_id');
        $this->developer_project_specification->is_great = array_get($this->data, 'is_great');
        $this->developer_project_specification->developer_type = array_get($this->data, 'developer_type');
        $this->developer_project_specification->project_category = array_get($this->data, 'project_category');
        $this->developer_project_specification->status = array_get($this->data, 'status');
        $this->developer_project_specification->province_id = array_get($this->data, 'province_id');
        $this->developer_project_specification->column = array_get($this->data, 'column');
        $this->developer_project_specification->sort = array_get($this->data, 'sort');
        $this->developer_project_specification->product_category_id = array_get($this->data, 'product_category_id');
        $this->developer_project_specification->user_id = array_get($this->data, 'user_id');
        $this->developer_project_specification->developer_id = array_get($this->data, 'developer_id');
    }
}