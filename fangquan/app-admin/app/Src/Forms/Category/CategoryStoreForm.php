<?php

namespace App\Admin\Src\Forms\Category;


use App\Admin\Src\Forms\Form;
use App\Src\Category\Domain\Model\CategoryEntity;
use App\Src\Category\Domain\Model\CategoryStatus;
use App\Src\Category\Infra\Repository\CategoryRepository;

class CategoryStoreForm extends Form
{
    /**
     * @var CategoryEntity
     */
    public $category_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                     => 'required|integer',
            'name'                   => 'required|string',
            'order'                  => 'nullable|integer',
            'price'                  => 'nullable|string',
            'image_id'               => 'nullable|integer',
            'category_attributes'    => 'nullable|array',
            'category_params'        => 'nullable|array',
            'category_attribute_ids' => 'nullable|array',
            'parent_id'              => 'nullable|integer',
            'icon_font'              => 'nullable|string',
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
            'id'                     => '标识',
            'name'                   => '名称',
            'order'                  => '排序',
            'image_id'               => '图标',
            'price'                  => '面价单位',
            'category_attributes'    => '属性',
            'category_attribute_ids' => '属性id',
            'category_params'        => '自定义参数',
            'parent_id'              => '父级',
            'icon_font'              => 'icon',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $category_repository = new CategoryRepository();
            /** @var CategoryEntity $category_entity */
            $category_entity = $category_repository->fetch(array_get($this->data, 'id'));
        } else {
            $category_entity = new CategoryEntity();
            $category_entity->created_user_id = request()->user()->id;
            $category_entity->status = CategoryStatus::YES;
        }

        $category_entity->parent_id = array_get($this->data, 'parent_id');
        $category_entity->name = array_get($this->data, 'name');
        $category_entity->order = array_get($this->data, 'order');
        $category_entity->price = array_get($this->data, 'price') ?? '';
        $category_entity->image_id = array_get($this->data, 'image_id');
        $category_entity->icon_font = array_get($this->data, 'icon_font') ?? '';
        $category_entity->category_attribute_ids = array_get($this->data, 'category_attribute_ids');
        $category_entity->category_attributes = array_filter(array_get($this->data, 'category_attributes'));
        $category_entity->category_params = array_filter(array_get($this->data, 'category_params'));
        $this->category_entity = $category_entity;
    }

}