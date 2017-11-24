<?php

namespace App\Admin\Src\Forms\Tag;

use App\Admin\Src\Forms\Form;

class TagDeleteForm extends Form
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
            'id' => '标识',
        ];
    }

    public function validation()
    {
        $this->id = array_get($this->data, 'id');
    }

}