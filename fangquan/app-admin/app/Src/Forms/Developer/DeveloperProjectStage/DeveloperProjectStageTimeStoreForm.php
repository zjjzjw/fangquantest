<?php

namespace App\Admin\Src\Forms\Developer\DeveloperProjectStage;


use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStageTimeEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectStageTimeRepository;

class DeveloperProjectStageTimeStoreForm extends Form
{
    /**
     * @var DeveloperEntity
     */
    public $developer_project_stage_time_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|integer',
            'project_id' => 'required|string',
            'time'       => 'required|date_format:Y-m-d H:i:s',
            'stage_type' => 'required|integer',
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
            'id'         => '标识',
            'project_id' => '项目id',
            'time'       => '阶段时间',
            'stage_type' => '阶段id',
        ];
    }

    public function validation()
    {
        $developer_project_stage_time_repository = new DeveloperProjectStageTimeRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var DeveloperProjectStageTimeEntity $developer_project_stage_time_entity */
            $developer_project_stage_time_entity = $developer_project_stage_time_repository->fetch(array_get($this->data, 'id'));
        } else {
            $developer_project_stage_time_entity = new DeveloperEntity();
        }

        $rank = array_get($this->data, 'rank');
        $project_id = array_get($this->data, 'project_id');
        $stage_type = array_get($this->data, 'stage_type');
        if ($developer_project_stage_time_entity->id != $id) {
            $developer_rank_entity = $developer_project_stage_time_repository->getDeveloperProjectStageTimeByProjectIdAndType($project_id, $stage_type);
            if (!$developer_rank_entity->isEmpty()) {
                $this->addError('stage_type', '已有该阶段时间,请前去修改');
            }
        }

        $developer_project_stage_time_entity->project_id = $project_id;
        $developer_project_stage_time_entity->time = array_get($this->data, 'time');
        $developer_project_stage_time_entity->stage_type = $stage_type;
        $this->developer_project_stage_time_entity = $developer_project_stage_time_entity;
    }

}