<?php

namespace App\Admin\Src\Forms\Theme;


use App\Admin\Src\Forms\Form;
use App\Src\Theme\Domain\Model\ThemeEntity;
use App\Src\Theme\Infra\Repository\ThemeRepository;

class ThemeStoreForm extends Form
{
    /**
     * @var ThemeEntity
     */
    public $theme_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'    => 'required|integer',
            'name'  => 'required|string',
            'order' => 'required|integer',
            'type'  => 'nullable|integer',
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
            'id'    => '标识',
            'name'  => '名称',
            'type'  => '类型',
            'order' => '排序',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $theme_repository = new ThemeRepository();
            /** @var ThemeEntity $theme_entity */
            $theme_entity = $theme_repository->fetch(array_get($this->data, 'id'));
        } else {
            $theme_entity = new ThemeEntity();
            $theme_entity->created_user_id = request()->user()->id;
            $theme_entity->type = 0;
        }

        $theme_entity->name = array_get($this->data, 'name');
        $theme_entity->type = array_get($this->data, 'type');
        $theme_entity->order = array_get($this->data, 'order');
        $this->theme_entity = $theme_entity;
    }

}