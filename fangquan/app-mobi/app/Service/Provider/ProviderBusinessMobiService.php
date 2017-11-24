<?php

namespace App\Mobi\Service\Provider;


use App\Src\Provider\Domain\Model\ProviderBusinessEntity;
use App\Src\Provider\Domain\Model\ProviderEntity;
use App\Src\Provider\Domain\Model\ProviderImageType;
use App\Src\Provider\Domain\Model\ProviderPictureEntity;
use App\Src\Provider\Infra\Repository\ProviderBusinessRepository;
use App\Src\Provider\Infra\Repository\ProviderPictureRepository;
use App\Src\Provider\Infra\Repository\ProviderRepository;
use App\Src\Surport\Domain\Model\ResourceEntity;
use App\Src\Surport\Infra\Repository\ResourceRepository;

class ProviderBusinessMobiService
{


    /**
     * 获取工商信息
     * @param $provider_id
     * @return array
     */
    public function getProviderBusinessByProviderId($provider_id)
    {
        $provider_repository = new ProviderRepository();
        /** @var ProviderEntity $provider_entity */
        $provider_entity = $provider_repository->fetch($provider_id);
        //获取图片信息
        $provider_picture_repository = new ProviderPictureRepository();
        $resource_repository = new ResourceRepository();
        $provider_picture_entities = $provider_picture_repository->getImageByProviderId($provider_id);
        $image_ids = [];
        /** @var ProviderPictureEntity $provider_picture_entity */
        foreach ($provider_picture_entities as $provider_picture_entity) {
            $image_ids[] = $provider_picture_entity->image_id;
        }
        $resource_entities = $resource_repository->getResourceUrlByIds($image_ids);
        /** @var ResourceEntity $resource_entity */
        $images = [];
        foreach ($provider_picture_entities as $provider_picture_entity) {
            $image = $provider_picture_entity->toArray();
            foreach ($resource_entities as $resource_entity) {
                if ($provider_picture_entity->image_id == $resource_entity->id) {
                    $image['url'] = $resource_entity->url;
                }
            }
            $images[] = $image;
        }
        $logo_arr = collect($images)->where('type', ProviderImageType::LOGO)->toArray();

        $provider['id'] = $provider_entity->id;
        $provider['company_name'] = $provider_entity->company_name;
        $provider['registered_capital'] = $provider_entity->registered_capital;
        $provider['corp'] = $provider_entity->corp;
        $provider['telphone'] = $provider_entity->telphone;
        $provider['founding_time'] = $provider_entity->founding_time;
        $provider['logo'] = current($logo_arr)['url'];
        $provider['business_memu'] = $this->getBusinessMemu($provider['id']);

        return $provider;
    }


    public function getBusinessMemu($provider_id)
    {
        $business_memu = [
            'company_backend'       => [
                [
                    'name'    => '工商信息',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'base_info');
                    }),
                ],
                [
                    'name'    => '股东信息',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'shareholder_info');
                    }),
                ],
                [
                    'name'    => '主要人员',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'main_person');
                    }),
                ],
                [
                    'name'    => '变更记录',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'change_record');
                    }),
                ],
            ],
            'company_develop'       => [
                [
                    'name'    => '融资历史',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'financing_history');
                    }),
                ],
                [
                    'name'    => '核心团队',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'core_team');
                    }),
                ],
                [
                    'name'    => '企业业务',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'enterprise_business');
                    }),
                ],

            ],
            'risk_info'             => [
                [
                    'name'    => '法律诉讼',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'legal_proceedings');
                    }),
                ],
                [
                    'name'    => '法律公告',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'court_notice');
                    }),
                ],
                [
                    'name'    => '失信信息',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'dishonest_person');
                    }),
                ],
                [
                    'name'    => '被执行人',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'person_subjected_execution');
                    }),
                ],
                [
                    'name'    => '行政处罚',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'administrative_sanction');
                    }),
                ],
                [
                    'name'    => '严重违法',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'serious_violation');
                    }),
                ],
                [
                    'name'    => '股权出资',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'stock_ownership');
                    }),
                ],
                [
                    'name'    => '动产抵押',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'chattel_mortgage');
                    }),
                ],
                [
                    'name'    => '欠税公告',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'tax_notice');
                    }),
                ],
                [
                    'name'    => '经营异常',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'abnormal_operation');
                    }),
                ],

            ],
            'manage_info'           => [
                [
                    'name'    => '招投标',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'bidding');
                    }),
                ],
                [
                    'name'    => '资质证书',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'qualification_certificate');
                    }),
                ],
                [
                    'name'    => '购地信息',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'purchase_information');
                    }),
                ],
                [
                    'name'    => '税务等级',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'tax_rating');
                    }),
                ],
            ],
            'intellectual_property' => [
                [
                    'name'    => '商标信息',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'trademark_information');
                    }),
                ],
                [
                    'name'    => '专利信息',
                    'icon'    => '',
                    'is_info' => value(function () use ($provider_id) {
                        return $this->getProviderBusinessInfoByProviderId($provider_id, 'patent');
                    }),
                ],
            ],
        ];
        return $business_memu;
    }

    /**
     * 获取供应商信息
     * @param $id
     * @return ProviderBusinessEntity
     */
    public
    function getProviderBusinessInfoById($id)
    {
        $provider_business_repository = new ProviderBusinessRepository();
        /** @var ProviderBusinessEntity $provider_business_entity */
        $provider_business_entity = $provider_business_repository->getProviderBusinessByProviderId($id);
        return $provider_business_entity;
    }

    /**
     * 判断工商信息是否存在
     * @param $provider_id
     * @param $field
     * @return bool
     */
    public function getProviderBusinessInfoByProviderId($provider_id, $field)
    {
        $provider_business_repository = new ProviderBusinessRepository();
        /** @var ProviderBusinessEntity $provider_business_entity */
        $provider_business_entity = $provider_business_repository->getProviderBusinessByProviderId($provider_id);
        $info = json_decode($provider_business_entity->{$field}, true);
        if (!empty($info)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 工商基本信息
     * @param $id
     * @return array
     */
    public
    function getProviderBusinessById($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $basic_info = json_decode($provider_business_entity->base_info, true);
        return $basic_info ?? [];
    }

    /**
     * 股东信息
     * @param $id
     * @return array|mixed
     */
    public
    function getShareholder($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $shareholder_info = json_decode($provider_business_entity->shareholder_info, true);
        return $shareholder_info ?? [];
    }

    /**
     * 主要人员
     * @param $id
     * @return array|mixed
     */
    public
    function getMainPerson($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $main_person = json_decode($provider_business_entity->main_person, true);
        return $main_person ?? [];
    }

    /**
     * 变更记录
     * @param $id
     * @return array|mixed
     */
    public
    function getChangeRecord($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $change_record = json_decode($provider_business_entity->change_record, true);
        return $change_record ?? [];
    }

    /**
     * 融资历史
     * @param $id
     * @return array|mixed
     */
    public
    function getFinancingHistory($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $financing_history = json_decode($provider_business_entity->financing_history, true);
        return $financing_history ?? [];
    }

    /**
     * 核心团队
     * @param $id
     * @return array|mixed
     */
    public
    function getCoreTeam($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $core_team = json_decode($provider_business_entity->core_team, true);
        return $core_team ?? [];
    }

    /**
     * 企业业务
     * @param $id
     * @return array|mixed
     */
    public
    function getEnterpriseBusiness($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $enterprise_business = json_decode($provider_business_entity->enterprise_business, true);
        return $enterprise_business ?? [];
    }

    /**
     * 法律诉讼
     * @param $id
     * @return array|mixed
     */
    public
    function getEegalProceedings($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $legal_proceedings = json_decode($provider_business_entity->legal_proceedings, true);
        return $legal_proceedings ?? [];
    }

    /**
     * 法院公告
     * @param $id
     * @return array|mixed
     */
    public
    function getCourtNotice($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $court_notice = json_decode($provider_business_entity->court_notice, true);
        return $court_notice ?? [];
    }

    /**
     * 失信人
     * @param $id
     * @return array|mixed
     */
    public
    function getDishonestPersonInfo($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $dishonest_person = json_decode($provider_business_entity->dishonest_person, true);
        return $dishonest_person ?? [];
    }

    /**
     * 被执行人
     * @param $id
     * @return array|mixed
     */
    public
    function getPersonSubjectedExecution($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $person_subjected_execution = json_decode($provider_business_entity->person_subjected_execution, true);
        return $person_subjected_execution ?? [];
    }

    /**
     * 行政处罚
     * @param $id
     * @return array|mixed
     */
    public
    function getAdministrativeSanction($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $administrative_sanction = json_decode($provider_business_entity->administrative_sanction, true);
        return $administrative_sanction ?? [];
    }

    /**
     * 严重违规
     * @param $id
     * @return array|mixed
     */
    public
    function getSeriousViolation($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $serious_violation = json_decode($provider_business_entity->serious_violation, true);
        return $serious_violation ?? [];
    }

    /**
     * 股权出资
     * @param $id
     * @return array|mixed
     */
    public
    function getStockOwnership($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $stock_ownership = json_decode($provider_business_entity->stock_ownership, true);
        return $stock_ownership ?? [];
    }

    /**
     * 动产抵押
     * @param $id
     * @return array|mixed
     */
    public
    function getChattelMortgage($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $chattel_mortgage = json_decode($provider_business_entity->chattel_mortgage, true);
        return $chattel_mortgage ?? [];
    }

    /**
     * 欠税公告
     * @param $id
     * @return array|mixed
     */
    public
    function getTaxNotice($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $tax_notice = json_decode($provider_business_entity->tax_notice, true);
        return $tax_notice ?? [];
    }

    /**
     * 经营异常
     * @param $id
     * @return array|mixed
     */
    public
    function getAbnormalOperation($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $abnormal_operation = json_decode($provider_business_entity->abnormal_operation, true);
        return $abnormal_operation ?? [];
    }

    /**
     * 税务等级
     * @param $id
     * @return array|mixed
     */
    public
    function getTaxRating($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $tax_rating = json_decode($provider_business_entity->tax_rating, true);
        return $tax_rating ?? [];
    }

    /**
     * 招投标
     * @param $id
     * @return array|mixed
     */
    public
    function getBidding($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $bidding = json_decode($provider_business_entity->bidding, true);
        return $bidding ?? [];
    }

    /**
     * 购地信息
     * @param $id
     * @return array|mixed
     */
    public
    function getPurchaseInformation($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $purchase_information = json_decode($provider_business_entity->purchase_information, true);
        return $purchase_information ?? [];
    }

    /**
     * 资质证书
     * @param $id
     * @return array|mixed
     */
    public
    function getQualificationCertificate($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $qualification_certificate = json_decode($provider_business_entity->qualification_certificate, true);
        return $qualification_certificate ?? [];
    }

    /**
     * 商标信息
     * @param $id
     * @return array|mixed
     */
    public
    function getTrademarkInformation($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $trademark_information = json_decode($provider_business_entity->trademark_information, true);
        return $trademark_information ?? [];
    }

    /**
     * 专利信息
     * @param $id
     * @return array|mixed
     */
    public
    function getPatent($id)
    {
        $provider_business_entity = $this->getProviderBusinessInfoById($id);
        if (empty($provider_business_entity)) return [];
        $patent = json_decode($provider_business_entity->patent, true);
        return $patent ?? [];
    }
}