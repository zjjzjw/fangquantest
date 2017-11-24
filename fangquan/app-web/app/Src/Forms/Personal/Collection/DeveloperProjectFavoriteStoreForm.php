<?php

namespace App\Web\Src\Forms\Personal\Collection;


use App\Admin\Src\Forms\Form;
use App\Src\Developer\Domain\Model\DeveloperEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectFavoriteEntity;
use App\Src\Developer\Domain\Model\DeveloperProjectStatus;
use App\Src\Developer\Domain\Model\DeveloperStatus;
use App\Src\Developer\Infra\Repository\DeveloperProjectFavoriteRepository;
use App\Src\Developer\Infra\Repository\DeveloperRepository;
use App\Src\Developer\Infra\Repository\DeveloperProjectRepository;

class DeveloperProjectFavoriteStoreForm extends Form
{
    /**
     * @var DeveloperProjectFavoriteEntity
     */
    public $developer_project_favorite_entity;

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
        $user_id = request()->user()->id;
        $developer_project_id = array_get($this->data, 'developer_project_id');
        $developer_project_favorite_repository = new DeveloperProjectFavoriteRepository();
        $developer_project_favorite_entity = $developer_project_favorite_repository->getFavoriteByUserIdAndProjectId(
            $user_id, $developer_project_id);

        if ($developer_project_favorite_entity->isEmpty()) {
            $developer_project_favorite_entity = new DeveloperProjectFavoriteEntity();
            $developer_project_favorite_entity->user_id = $user_id;
            $developer_project_favorite_entity->developer_project_id = $developer_project_id;
            $this->developer_project_favorite_entity = $developer_project_favorite_entity;
        }else{
            $this->addError('developer_project_id','已收藏');
        }
    }

}