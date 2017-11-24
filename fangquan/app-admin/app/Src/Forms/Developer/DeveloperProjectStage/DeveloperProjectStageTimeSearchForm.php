<?php

namespace App\Admin\Src\Forms\Developer\DeveloperProjectStage;

use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeSpecification;
use App\Admin\Src\Forms\Form;

class DeveloperProjectStageTimeSearchForm extends Form
{
    /**
     * @var DeveloperProjectStageTimeSpecification
     */
    public $developer_project_stage_time_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'    => 'string',
            'project_id' => 'integer',
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
            'keyword'    => '关键字',
            'project_id' => '项目id',
        ];
    }

    public function validation()
    {
        $this->developer_project_stage_time_specification = new DeveloperProjectStageTimeSpecification();
        $this->developer_project_stage_time_specification->keyword = array_get($this->data, 'keyword');
        $this->developer_project_stage_time_specification->project_id = array_get($this->data, 'project_id');
    }
}