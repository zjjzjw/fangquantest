<?php namespace App\Mobi\Src\Forms\Provider\ProviderProject;

use App\Mobi\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderProjectEntity;
use App\Src\Provider\Infra\Repository\ProviderProjectRepository;

class  ProviderProjectStoreForm extends Form
{
    /**
     * @var ProviderProjectEntity
     */
    public $provider_project_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                        => 'required|integer',
            'provider_id'               => 'required|integer',
            'name'                      => 'required|string|max:50',
            'developer_name'            => 'required|string|max:50',
            'time'                      => 'required|string',
            'province_id'               => 'required|integer',
            'city_id'                   => 'required|integer',
            'status'                    => 'required|integer',
            'provider_project_products' => 'required|array',
            'provider_project_pictures' => 'required|array',
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
            'id'                        => '标识',
            'provider_id'               => '供应商ID',
            'name'                      => '项目名称',
            'developer_name'            => '开发商名称',
            'province_id'               => '省份',
            'city_id'                   => '城市',
            'time'                      => '合同签订时间',
            'provider_project_products' => '产品属性',
            'provider_project_pictures' => '产品图片',
        ];
    }

    public function validation()
    {
        if ($id = array_get($this->data, 'id')) {
            $provider_news_repository = new ProviderProjectRepository();
            /** @var ProviderProjectEntity $provider_project_entity */
            $provider_project_entity = $provider_news_repository->fetch($id);
        } else {
            $provider_project_entity = new ProviderProjectEntity();
        }

        $provider_project_entity->provider_id = array_get($this->data, 'provider_id');
        $provider_project_entity->name = array_get($this->data, 'name');
        $provider_project_entity->developer_name = array_get($this->data, 'developer_name');
        $provider_project_entity->province_id = array_get($this->data, 'province_id');
        $provider_project_entity->city_id = array_get($this->data, 'city_id');
        $provider_project_entity->time = array_get($this->data, 'time');
        $provider_project_entity->status = array_get($this->data, 'status');
        $provider_project_entity->provider_project_products = $this->formatDataFromHorToVert($this->data['provider_project_products'], ['name', 'num', 'measureunit_id']);
        $provider_project_entity->provider_project_picture_ids = array_get($this->data, 'provider_project_pictures');

        $this->provider_project_entity = $provider_project_entity;
    }
}