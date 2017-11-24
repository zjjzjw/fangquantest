<?php
namespace App\Admin\Src\Forms\Information;

use App\Src\Information\Domain\Model\InformationSpecification;
use App\Admin\Src\Forms\Form;

class InformationSearchForm extends Form
{
    /**
     * @var InformationSpecification
     */
    public $information_specification;

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
        $this->information_specification = new InformationSpecification();
        $this->information_specification->keyword = array_get($this->data, 'keyword');
    }
}