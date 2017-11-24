<?php

namespace App\Mobi\Src\Forms\Provider;

use App\Src\Provider\Domain\Model\ProjectCaseCountType;
use App\Src\Provider\Domain\Model\ProviderAdType;
use App\Src\Provider\Domain\Model\ProviderSpecification;
use App\Mobi\Src\Forms\Form;
use App\Src\Provider\Domain\Model\RegisteredCapitalType;
use Illuminate\Support\MessageBag;

class ProviderSearchForm extends Form
{

    /**
     * @var ProviderSpecification
     */
    public $provider_specification;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'             => 'nullable|string',
            'category_id'         => 'nullable|integer', //产品类别
            'province_id'         => 'nullable|string',
            'operation_mode'      => 'nullable|integer',
            'project_count'       => 'nullable|integer',
            'registered_capital'  => 'nullable|integer',
            'product_category_id' => 'nullable|integer',
            'is_ad'               => 'nullable|integer',
            'page'                => 'nullable|integer',
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
        $this->provider_specification = new ProviderSpecification();
        $this->provider_specification->keyword = array_get($this->data, 'keyword');
        $this->provider_specification->product_category_id = array_get($this->data, 'product_category_id');
        $this->provider_specification->is_ad = array_get($this->data, 'is_ad');
        $this->provider_specification->operation_mode = array_get($this->data, 'operation_mode');
        if (array_get($this->data, 'project_count')) {
            $project_case_count_ranges = ProjectCaseCountType::acceptableLimits();
            $project_case_count_start = null;
            $project_case_count_end = null;
            if (!empty($project_case_count_ranges[$this->project_case_count_type])) {
                $project_case_count_start = $project_case_count_ranges[$this->project_case_count_type];
                $project_case_count_end = null;
            }
            $this->provider_specification->project_case_count_start = $project_case_count_start;
            $this->provider_specification->project_case_count_end = $project_case_count_end;
        }
        if (array_get($this->data, 'registered_capital')) {
            $registered_capital_ranges = RegisteredCapitalType::acceptableRanges();
            $registered_capital_start = null;
            $registered_capital_end = null;
            if (!empty($registered_capital_ranges[$this->registered_capital_type])) {
                $registered_capital_start = $registered_capital_ranges[$this->registered_capital_type][0];
                $registered_capital_end = $registered_capital_ranges[$this->registered_capital_type][1];
            }
            $this->provider_specification->registered_capital_end = $registered_capital_start;
            $this->provider_specification->registered_capital_end = $registered_capital_end;
        }
        $this->provider_specification->page = array_get($this->data, 'page');
        if (array_get($this->data, 'province_id')) {
            $this->provider_specification->province_id = explode(',', array_get($this->data, 'province_id'));
        }
    }

    /*
    * Handle a failed validation attempt.
    *
    * @param \Illuminate\Support\MessageBag $message
    */
    protected function failedValidation(MessageBag $message)
    {

    }

}