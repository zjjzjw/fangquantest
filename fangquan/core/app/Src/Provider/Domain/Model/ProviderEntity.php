<?php

namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;
use Carbon\Carbon;

class ProviderEntity extends Entity
{
    /**
     * @var int
     */
    public $id;


    public $identity_key = 'id';

    /**
     * @var string
     */
    public $company_name;

    /**
     * @var string
     */
    public $brand_name;

    /**
     * @var int
     */
    public $patent_count;

    /**
     * @var int
     */
    public $favorite_count;

    /**
     * @var int
     */
    public $product_count;

    /**
     * @var int
     */
    public $project_count;

    /**
     * @var int
     */
    public $province_id;

    /**
     * @var int
     */
    public $city_id;

    /**
     * @var string
     */
    public $operation_address;

    /**
     * @var int
     */
    public $produce_province_id;

    /**
     * @var int
     */
    public $produce_city_id;
    /**
     * @var string
     */
    public $produce_address;

    /**
     * @var string
     */
    public $telphone;

    /**
     * @var string
     */
    public $fax;

    /**
     * @var string
     */
    public $service_telphone;

    /**
     * @var string
     */
    public $website;

    /**
     * @var string
     */
    public $operation_mode;

    /**
     * @var integer
     */
    public $founding_time;

    /**
     * @var string
     */
    public $turnover;

    /**
     * @var float
     */
    public $registered_capital;

    /**
     * @var string
     */
    public $registered_capital_unit;

    /**
     * @var int
     */
    public $worker_count;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var string
     */
    public $corp;

    /**
     * @var int
     */
    public $score_scale;

    /**
     * @var int
     */
    public $score_qualification;

    /**
     * @var int
     */
    public $score_credit;

    /**
     * @var int
     */
    public $score_innovation;

    /**
     * @var int
     */
    public $score_service;

    /**
     * @var int
     */
    public $contact;

    /**
     * @var int
     */
    public $integrity;

    /**
     * @var int
     */
    public $status;

    /**
     * @var int
     */
    public $is_ad;

    /**
     * @var int
     */
    public $rank;

    /**
     * @var int
     */
    public $company_type;

    /**
     * @var string
     */
    public $corp_phone;

    /**
     * @var ProviderPictureEntity
     */
    public $provider_pictures;

    /**
     * @var ProviderMainCategoryEntity
     */
    public $provider_main_category;

    /**
     * @var array
     */
    public $provider_domestic_imports;

    /**
     * @var array
     */
    public $provider_management_modes;

    /**
     * @var array
     */
    public $brand_friends;


    public function __construct()
    {
    }

    public function toArray($is_filter_null = false)
    {
        return [
            'id'                        => $this->id,
            'company_name'              => $this->company_name,
            'brand_name'                => $this->brand_name,
            'patent_count'              => $this->patent_count,
            'favorite_count'            => $this->favorite_count,
            'product_count'             => $this->product_count,
            'project_count'             => $this->project_count,
            'province_id'               => $this->province_id,
            'city_id'                   => $this->city_id,
            'operation_address'         => $this->operation_address,
            'produce_province_id'       => $this->produce_province_id,
            'produce_city_id'           => $this->produce_city_id,
            'produce_address'           => $this->produce_address,
            'telphone'                  => $this->telphone,
            'fax'                       => $this->fax,
            'service_telphone'          => $this->service_telphone,
            'website'                   => $this->website,
            'operation_mode'            => $this->operation_mode,
            'founding_time'             => $this->founding_time,
            'turnover'                  => $this->turnover,
            'registered_capital'        => $this->registered_capital,
            'registered_capital_unit'   => $this->registered_capital_unit,
            'worker_count'              => $this->worker_count,
            'summary'                   => $this->summary,
            'corp'                      => $this->corp,
            'score_scale'               => $this->score_scale,
            'score_qualification'       => $this->score_qualification,
            'score_credit'              => $this->score_credit,
            'score_innovation'          => $this->score_innovation,
            'score_service'             => $this->score_service,
            'contact'                   => $this->contact,
            'integrity'                 => $this->integrity,
            'status'                    => $this->status,
            'is_ad'                     => $this->is_ad,
            'rank'                      => $this->rank,
            'provider_pictures'         => $this->provider_pictures,
            'provider_main_category'    => $this->provider_main_category,
            'company_type'              => $this->company_type,
            'corp_phone'                => $this->corp_phone,
            'provider_management_modes' => $this->provider_management_modes,
            'provider_domestic_imports' => $this->provider_domestic_imports,
            'brand_friends'             => $this->brand_friends,
            'created_at'                => $this->created_at->toDateTimeString(),
            'updated_at'                => $this->updated_at->toDateTimeString(),
        ];
    }

}