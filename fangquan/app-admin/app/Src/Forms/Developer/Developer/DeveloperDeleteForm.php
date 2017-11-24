<?php

namespace App\Admin\Src\Forms\Developer\Developer;

use App\Admin\Src\Forms\Form;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;

class DeveloperDeleteForm extends Form
{


    /**
     * @var int
     */
    public $id;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
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
            'id'                => '标识',
            'developer_project' => '项目',
        ];
    }

    public function validation()
    {
        $this->id = array_get($this->data, 'id');
        $developer_project_repository = new DeveloperProjectRepository();
        $developer_project_list = $developer_project_repository->getProjectListByDeveloperId($this->id);
        if (!$developer_project_list->isEmpty()) {
            $this->addError('developer_project', '需清空已有的项目才能删除!');
        }
    }

}