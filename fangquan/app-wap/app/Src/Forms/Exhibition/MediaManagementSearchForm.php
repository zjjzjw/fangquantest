<?php

namespace App\Wap\Src\Forms\Exhibition;

use App\Src\MediaManagement\Domain\Model\MediaManagementSpecification;
use App\Admin\Src\Forms\Form;

class MediaManagementSearchForm extends Form
{
    /**
     * @var MediaManagementSpecification
     */
    public $media_management_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'nullable|string',

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
        $this->media_management_specification = new MediaManagementSpecification();
        $this->media_management_specification->keyword = array_get($this->data, 'keyword');
    }
}