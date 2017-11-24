<?php

namespace App\Web\Src\Forms\Personal\Collection;

use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;

class DeveloperProjectFavoriteDeleteForm extends Form
{


    /**
     * @var int
     */
    public $id;

    public $developer_project_id;
    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                   => 'required|integer',
            'developer_project_id' => 'required|integer',
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
            'id'                   => '标识',
            'developer_project_id' => '项目id',
        ];
    }

    public function validation()
    {
        $this->id = array_get($this->data, 'id');
        $developer_project_id = array_get($this->data, 'developer_project_id');
        $user_id = request()->user()->id;
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_favorite_entities = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
            $user_id, $developer_project_id);
        if (!$developer_project_favorite_entities->isEmpty()) {
            $developer_project_favorite_ids = [];
            /** @var DeveloperProjectFavoriteEntity $developer_project_favorite_entity */
            foreach ($developer_project_favorite_entities as $developer_project_favorite_entity) {
                $developer_project_favorite_ids[] = $developer_project_favorite_entity->id;
            }
            $this->developer_project_id = $developer_project_favorite_ids;
        }else{
            $this->addError('developer_project_id', '操作有误');
        }
    }

}