<?php

namespace App\Mobi\Src\Forms\Developer\DeveloperProjectFavorite;

use App\Mobi\Src\Forms\Form;
use Illuminate\Support\MessageBag;

class DeveloperProjectFavoriteDeleteForm extends Form
{
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
            'id' => '项目收藏ID',
        ];
    }

    public function validation()
    {

    }

    public function failedValidation(MessageBag $message)
    {

    }
}