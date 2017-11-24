<?php
namespace App\Admin\Src\Forms\Advertisement;

use App\Src\Advertisement\Domain\Model\AdvertisementSpecification;
use App\Admin\Src\Forms\Form;

class AdvertisementSearchForm extends Form
{
    /**
     * @var AdvertisementSpecification
     */
    public $advertisement_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword' => 'string',
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
        $this->advertisement_specification = new AdvertisementSpecification();
        $this->advertisement_specification->keyword = array_get($this->data, 'keyword');
    }
}