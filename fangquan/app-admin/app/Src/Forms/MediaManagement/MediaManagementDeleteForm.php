<?php

namespace App\Admin\Src\Forms\MediaManagement;

use App\Admin\Src\Forms\Form;

class MediaManagementDeleteForm extends Form
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

    }

}