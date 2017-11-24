<?php

namespace App\Admin\Src\Forms\Provider;

use App\Admin\Src\Forms\Form;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderStatus;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use Carbon\Carbon;

class  ProviderStoreForm extends Form
{
    /**
     * @var ProviderEntity
     */
    public $provider_entity;

    /**
     * Get the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                        => 'required|integer',
            'company_name'              => 'required|string',
            'brand_name'                => 'required|string',
            'patent_count'              => 'nullable|integer',
            'favorite_count'            => 'nullable|integer',
            'product_count'             => 'nullable|integer',
            'province_id'               => 'nullable|integer',
            'city_id'                   => 'nullable|integer',
            'operation_address'         => 'nullable|string',
            'produce_province_id'       => 'nullable|integer',
            'produce_city_id'           => 'nullable|integer',
            'produce_address'           => 'nullable|string',
            'telphone'                  => 'nullable|string',
            'fax'                       => 'nullable|string',
            'service_telphone'          => 'nullable|string',
            'website'                   => 'nullable|string',
            'operation_mode'            => 'nullable|integer',
            'founding_time'             => 'nullable|integer',
            'turnover'                  => 'nullable|integer',
            'registered_capital'        => 'nullable|numeric',
            'worker_count'              => 'nullable|integer',
            'summary'                   => 'nullable|string',
            'corp'                      => 'nullable|string',
            'score_scale'               => 'nullable|integer',
            'score_qualification'       => 'nullable|integer',
            'score_credit'              => 'nullable|integer',
            'score_innovation'          => 'nullable|integer',
            'score_service'             => 'nullable|integer',
            'contact'                   => 'nullable|string',
            'integrity'                 => 'nullable|integer',
            'status'                    => 'nullable|integer',
            'is_ad'                     => 'required|integer',
            'rank'                      => 'required|integer',
            'registered_capital_unit'   => 'nullable|string',
            'company_type'              => 'nullable|integer',
            'corp_phone'                => 'nullable|string',
            'provider_domestic_imports' => 'nullable|array',
            'provider_management_modes' => 'nullable|array',
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
            'company_name'              => '公司名称',
            'brand_name'                => '品牌名',
            'patent_count'              => '专利数',
            'favorite_count'            => '收藏次数',
            'product_count'             => '产品数量',
            'project_count'             => '项目数量',
            'province_id'               => '省份',
            'city_id'                   => '城市',
            'operation_address'         => '经营地址',
            'produce_province_id'       => '生产地址省份ID',
            'produce_city_id'           => '生产地址城市ID',
            'produce_address'           => '生产地址',
            'telphone'                  => '电话',
            'fax'                       => '传真',
            'service_telphone'          => '服务热线',
            'website'                   => '企业网站',
            'operation_mode'            => '经营模式',
            'founding_time'             => '成立时间',
            'turnover'                  => '年营业额',
            'registered_capital'        => '注册资金',
            'worker_count'              => '员工人数',
            'summary'                   => '企业简介',
            'corp'                      => '公司法人',
            'score_scale'               => '企业规模分数',
            'score_qualification'       => '行业资质分数',
            'score_credit'              => '企业信用分数',
            'score_innovation'          => '创新能力分数',
            'score_service'             => '服务体系分数',
            'contact'                   => '联系人',
            'integrity'                 => '资料完整度',
            'status'                    => '供应商状态',
            'is_ad'                     => '是否广告',
            'rank'                      => '排名',
            'company_type'              => '公司类型',
            'corp_phone'                => '法人联系电话',
            'provider_domestic_imports' => '产品产地',
            'provider_management_modes' => '经营模式',
        ];
    }

    public function validation()
    {
        $provider_repository = new ProviderRepository();
        if ($id = array_get($this->data, 'id')) {
            /** @var ProviderEntity $provider_entity */
            $provider_entity = $provider_repository->fetch($id);
        } else {
            $provider_entity = new ProviderEntity();
            $provider_entity->project_count = 0;
            $provider_entity->favorite_count = 0;
            $provider_entity->patent_count = 0;
            $provider_entity->product_count = 0;
            $provider_entity->score_scale = 0;
            $provider_entity->score_qualification = 0;
            $provider_entity->score_credit = 0;
            $provider_entity->score_innovation = 0;
            $provider_entity->score_service = 0;
            $provider_entity->integrity = 10;
        }


        $provider_pictures = [];
        $provider_entity->company_name = array_get($this->data, 'company_name');
        $provider_entity->brand_name = array_get($this->data, 'brand_name');
        $provider_entity->province_id = array_get($this->data, 'province_id', 0) ?? 0;
        $provider_entity->city_id = array_get($this->data, 'city_id', 0) ?? 0;
        $provider_entity->operation_address = array_get($this->data, 'operation_address') ?? '';
        $provider_entity->produce_province_id = array_get($this->data, 'produce_province_id', 0) ?? 0;
        $provider_entity->produce_city_id = array_get($this->data, 'produce_city_id', 0) ?? 0;
        $provider_entity->produce_address = array_get($this->data, 'produce_address') ?? '';
        $provider_entity->telphone = array_get($this->data, 'telphone') ?? '';
        $provider_entity->fax = array_get($this->data, 'fax', '') ?? '';

        $provider_main_category = array_get($this->data, 'provider_main_category');
        $provider_entity->provider_main_category = $provider_main_category ? explode(',', $provider_main_category) : [];

        $provider_entity->service_telphone = array_get($this->data, 'service_telphone') ?? '';
        $provider_entity->website = array_get($this->data, 'website') ?? '';
        $provider_entity->contact = array_get($this->data, 'contact') ?? '';
        $provider_entity->operation_mode = array_get($this->data, 'operation_mode', 0) ?? 0;
        $provider_entity->founding_time = array_get($this->data, 'founding_time') ?? '0';
        $provider_entity->turnover = array_get($this->data, 'turnover') ?? 0;
        $provider_entity->registered_capital = array_get($this->data, 'registered_capital', '0.00') ?? 0.00;
        $provider_entity->worker_count = array_get($this->data, 'worker_count', 0) ?? 0;
        $provider_entity->summary = array_get($this->data, 'summary') ?? '';
        $provider_entity->corp = array_get($this->data, 'corp') ?? '';
        $provider_entity->is_ad = array_get($this->data, 'is_ad', 0);
        $provider_entity->rank = array_get($this->data, 'rank', 0);
        $provider_entity->company_type = array_get($this->data, 'company_type');
        $provider_entity->corp_phone = array_get($this->data, 'corp_phone') ?? '';
        $provider_entity->provider_management_modes = array_get($this->data, 'provider_management_modes');
        $provider_entity->provider_domestic_imports = array_get($this->data, 'provider_domestic_imports');
        $provider_entity->status = array_get($this->data, 'status') ?? 0;

        $provider_pictures = [];
        if ($logo = array_get($this->data, 'logo')) {
            $provider_pictures[] = ['type' => ProviderImageType::LOGO, 'image_id' => $logo];
        }
        if ($license = array_get($this->data, 'license')) {
            $provider_pictures[] = ['type' => ProviderImageType::LICENSE, 'image_id' => $license];
        }
        if ($provider_factory_image_ids = array_get($this->data, 'provider_factory_image_ids')) {
            foreach ($provider_factory_image_ids as $image_id) {
                $provider_pictures[] = ['type' => ProviderImageType::FACTORY, 'image_id' => $image_id];
            }
        }
        if ($provider_device_image_ids = array_get($this->data, 'provider_device_image_ids')) {
            foreach ($provider_device_image_ids as $image_id) {
                $provider_pictures[] = ['type' => ProviderImageType::DEVICE, 'image_id' => $image_id];
            }
        }
        if ($structure = array_get($this->data, 'structure')) {
            $provider_pictures[] = ['type' => ProviderImageType::STRUCTURE, 'image_id' => $structure];
        }
        if ($sub_structure = array_get($this->data, 'sub_structure')) {
            $provider_pictures[] = ['type' => ProviderImageType::SUB_STRUCTURE, 'image_id' => $sub_structure];
        }

        $provider_entity->registered_capital_unit = array_get($this->data, 'registered_capital_unit') ?? '';

        $provider_entity->provider_pictures = $provider_pictures;
        $this->provider_entity = $provider_entity;
    }
}