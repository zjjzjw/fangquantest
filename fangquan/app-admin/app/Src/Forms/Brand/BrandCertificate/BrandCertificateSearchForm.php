<?php
namespace App\Admin\Src\Forms\Brand\BrandCertificate;

use App\Src\Brand\Domain\Model\BrandCertificateSpecification;
use App\Admin\Src\Forms\Form;

class BrandCertificateSearchForm extends Form
{
    /**
     * @var BrandCertificateSpecification
     */
    public $brand_certificate_specification;

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
        $this->brand_certificate_specification = new BrandCertificateSpecification();
        $this->brand_certificate_specification->keyword = array_get($this->data, 'keyword');
        $this->brand_certificate_specification->brand_id = array_get($this->data, 'brand_id');
    }
}