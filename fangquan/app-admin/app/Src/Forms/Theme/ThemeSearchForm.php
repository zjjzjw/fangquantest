<?php
namespace App\Admin\Src\Forms\Theme;

use App\Src\Theme\Domain\Model\ThemeSpecification;
use App\Admin\Src\Forms\Form;

class ThemeSearchForm extends Form
{
    /**
     * @var ThemeSpecification
     */
    public $theme_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'nullable|string',
            'type'    => 'nullable|integer',
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
            'type'    => '类型',
        ];
    }

    public function validation()
    {
        $this->theme_specification = new ThemeSpecification();
        $this->theme_specification->keyword = array_get($this->data, 'keyword');
        $this->theme_specification->type = array_get($this->data, 'type');

    }

}