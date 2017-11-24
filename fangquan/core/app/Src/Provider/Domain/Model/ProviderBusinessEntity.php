<?php namespace App\Src\Provider\Domain\Model;

use App\Foundation\Domain\Entity;

class ProviderBusinessEntity extends Entity
{
    /**
     * @var int
     */
    public $id;

    public $identity_key = 'id';

    /**
     * @var int
     */
    public $provider_id;
    /**
     * @var string
     */
    public $base_info;
    /**
     * @var string
     */
    public $main_person;
    /**
     * @var string
     */
    public $shareholder_info;
    /**
     * @var string
     */
    public $change_record;
    /**
     * @var string
     */
    public $branchs;
    /**
     * @var string
     */
    public $financing_history;
    /**
     * @var string
     */
    public $core_team;
    /**
     * @var string
     */
    public $enterprise_business;
    /**
     * @var string
     */
    public $legal_proceedings;
    /**
     * @var string
     */
    public $court_notice;
    /**
     * @var string
     */
    public $dishonest_person;
    /**
     * @var string
     */
    public $person_subjected_execution;
    /**
     * @var string
     */
    public $abnormal_operation;
    /**
     * @var string
     */
    public $administrative_sanction;
    /**
     * @var string
     */
    public $serious_violation;
    /**
     * @var string
     */
    public $stock_ownership;
    /**
     * @var string
     */
    public $chattel_mortgage;
    /**
     * @var string
     */
    public $tax_notice;
    /**
     * @var string
     */
    public $bidding;
    /**
     * @var string
     */
    public $purchase_information;
    /**
     * @var string
     */
    public $tax_rating;
    /**
     * @var string
     */
    public $qualification_certificate;
    /**
     * @var string
     */
    public $trademark_information;
    /**
     * @var string
     */
    public $patent;


    public function toArray($is_filter_null = false)
    {
        return [
            'id'                         => $this->id,
            'provider_id'                => $this->provider_id,
            'base_info'                  => $this->base_info,
            'main_person'                => $this->main_person,
            'shareholder_info'           => $this->shareholder_info,
            'change_record'              => $this->change_record,
            'branchs'                    => $this->branchs,
            'financing_history'          => $this->financing_history,
            'core_team'                  => $this->core_team,
            'enterprise_business'        => $this->enterprise_business,
            'legal_proceedings'          => $this->legal_proceedings,
            'court_notice'               => $this->court_notice,
            'dishonest_person'           => $this->dishonest_person,
            'person_subjected_execution' => $this->person_subjected_execution,
            'abnormal_operation'         => $this->abnormal_operation,
            'administrative_sanction'    => $this->administrative_sanction,
            'serious_violation'          => $this->serious_violation,
            'stock_ownership'            => $this->stock_ownership,
            'chattel_mortgage'           => $this->chattel_mortgage,
            'tax_notice'                 => $this->tax_notice,
            'bidding'                    => $this->bidding,
            'purchase_information'       => $this->purchase_information,
            'tax_rating'                 => $this->tax_rating,
            'qualification_certificate'  => $this->qualification_certificate,
            'trademark_information'      => $this->trademark_information,
            'patent'                     => $this->patent,
            'created_at'                 => $this->created_at,
            'updated_at'                 => $this->updated_at,
        ];
    }

    public function __construct()
    {
    }
}