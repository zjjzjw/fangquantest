<?php

namespace App\Mobi\Src\Forms\Developer\DeveloperProject;

use App\Src\Developer\Domain\Model\DeveloperProjectSpecification;
use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderAdType;
use Illuminate\Contracts\Logging\Log;

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
            'keyword'          => 'nullable|string',
            'project_stage_id' => 'nullable|integer',//项目阶段
            'area_id'          => 'nullable|integer',
            'province_id'      => 'nullable|string',
            'is_great'         => 'nullable|integer',//是否优选 1=是 2=否
            'developer_type'   => 'nullable|integer',//开发商类型 1=百强开发商; 2=普通开发商
            'project_category' => 'nullable|integer',//项目类别 1 - 住宅、2 - 酒店、3 - 工业、4 - 办公楼、5 - 商业综合体、6其它
            'page'             => 'nullable|integer',
            'status'           => 'required|integer',//项目状态
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
        $this->developer_project_specification->keyword = array_get($this->data, 'keywords');
        $this->developer_project_specification->project_stage_id = array_get($this->data, 'project_stage_id');
        $this->developer_project_specification->is_great = array_get($this->data, 'is_great');
        $this->developer_project_specification->developer_type = array_get($this->data, 'developer_type');
        $this->developer_project_specification->project_category = array_get($this->data, 'project_category');
        $this->developer_project_specification->product_category_id = array_get($this->data, 'product_category_id');
        $this->developer_project_specification->status = array_get($this->data, 'status');
        $this->developer_project_specification->is_ad = ProviderAdType::NO;
        $this->developer_project_specification->page = array_get($this->data, 'page');
        if (array_get($this->data, 'province_id')) {
            $this->developer_project_specification->province_id = explode(',', array_get($this->data, 'province_id'));
        }
    }
}