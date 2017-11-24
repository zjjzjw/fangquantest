<?php

namespace App\Admin\Src\Forms\Category;


use App\Admin\Src\Forms\Form;
use App\Src\Category\Domain\Model\AttributeEntity;
use App\Src\Category\Infra\Repository\AttributeRepository;

class AttributeStoreForm extends Form
{
    /**
     * @var AttributeEntity
     */
    public $attribute_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                  => 'required|integer',
            'name'                => 'required|string',
            'order'               => 'required|integer',
            'category_id'               => 'required|integer',
            'attribute_values'    => 'nullable|array',
            'attribute_value_ids' => 'nullable|array',
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
            'id'                  => '标识',
            'name'                => '名称',
            'order'               => '排序',
            'category_id'               => '分类标识',
            'attribute_values'    => '类别',
            'attribute_value_ids' => '类别id',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $attribute_repository = new AttributeRepository();
            /** @var AttributeEntity $attribute_entity */
            $attribute_entity = $attribute_repository->fetch(array_get($this->data, 'id'));
        } else {
            $attribute_entity = new AttributeEntity();
        }
        $attribute_entity->name = array_get($this->data, 'name');
        $attribute_entity->attribute_value_ids = array_get($this->data, 'attribute_value_ids');
        $attribute_entity->category_id = array_get($this->data, 'category_id');
        $attribute_entity->order = array_get($this->data, 'order');
        $attribute_entity->attribute_values = array_filter(array_get($this->data, 'attribute_values'));
        $this->attribute_entity = $attribute_entity;
    }

}