<?php

namespace App\Web\Src\Forms\Provider\ProviderRankCategory;

use App\Src\Product\Domain\Model\ProductCategoryType;
use App\Src\Provider\Domain\Model\ProviderRankCategorySpecification;
use App\Web\Src\Forms\Form;

class ProviderRankCategorySearchForm extends Form
{

    /**
     * @var ProviderRankCategorySpecification
     */
    public $provider_rank_category_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'     => 'nullable|string',
            'provider_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误',
            'integer'     => ':attribute必须是数字',
            'string'      => ':attribute必须是字符串',
        ];
    }

    public function attributes()
    {
        return [
            'keyword'     => '关键字',
            'provider_id' => '唯一标识',
        ];
    }

    public function validation()
    {
        $this->provider_rank_category_specification = new ProviderRankCategorySpecification();
        $this->provider_rank_category_specification->keyword = array_get($this->data, 'keyword');
        $this->provider_rank_category_specification->provider_id = array_get($this->data, 'provider_id');
        $this->provider_rank_category_specification->category_id = array_get($this->data, 'category_id');
        if (!isset($this->provider_rank_category_specification->category_id)) {
            if ($category_id = request()->cookie('c_category_id')) {
                $this->provider_rank_category_specification->category_id = $category_id;
            } else {
                $this->provider_rank_category_specification->category_id = ProductCategoryType::WATER_HEATER;
            }
        }
    }
}