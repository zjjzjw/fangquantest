<?php

namespace App\Mobi\Src\Forms\Developer\DeveloperProjectFavorite;


use App\Mobi\Src\Forms\Form;
use App\Src\Exception\ParamException;
use Illuminate\Support\MessageBag;

class DeveloperProjectFavoriteStoreForm extends Form
{
    /**
     * @var array
     */
    public $developer_project_ids;

    /**
     * @var int
     */
    public $type;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'                 => 'required|integer',
            'developer_project_id' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必传',
            'date_format' => ':attribute格式错误',
        ];
    }

    public function attributes()
    {
        return [
            'type'                 => '操作类型',
            'developer_project_id' => '开发商项目ID',
        ];
    }

    public function validation()
    {
        $this->type = array_get($this->data, 'type');
        $this->developer_project_ids = explode(',', array_get($this->data, 'developer_project_id'));
    }

    public function failedValidation(MessageBag $message)
    {
        $msg = '';
        $messages = $this->formatErrors($message);
        if (!empty($messages)) {
            $msg = current(current($messages));
        }
        throw new ParamException(":" . $msg, ParamException::ERROR_PARAM);
    }
}