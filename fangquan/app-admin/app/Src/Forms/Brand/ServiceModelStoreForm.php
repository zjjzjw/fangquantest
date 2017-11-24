<?php

namespace App\Admin\Src\Forms\Brand;


use App\Admin\Src\Forms\Form;
use App\Src\Brand\Domain\Model\BrandServiceEntity;
use App\Src\Brand\Infra\Repository\BrandServiceRepository;

class ServiceModelStoreForm extends Form
{
    /**
     * @var $brand_service_entity
     */
    public $brand_service_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id'                => 'required|integer',
            'model_type'                => 'required|array',
        ];
    }

    protected function messages()
    {
        return [
            'required'    => ':attribute必填。',
            'date_format' => ':attribute格式错误。',
        ];
    }

    public function brand_services()
    {
        return [
            'service_id'                => '服务ID',
            'model_type' => '服务类型',
        ];
    }
    public function validation()
    {
        $brand_service_repository = new BrandServiceRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var $brand_service_entity $brand_entity */
            $brand_service_entity = $brand_service_repository->fetch(array_get($this->data, 'service_id'));
            $brand_service_entity->model_type = array_get($this->data, 'model_type');
            $this->brand_service_entity = $brand_service_entity;
        }else{
            $brand_service_entity = new BrandServiceEntity();
        }
        $brand_service_entity->model_type = array_get($this->data, 'model_type');
        $brand_service_entity->service_id = array_get($this->data, 'service_id');
        $this->brand_service_entity = $brand_service_entity;
    }

}