<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderBusinessModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_business';

    protected $fillable = [
        'provider_id',
        'base_info',
        'main_person',
        'shareholder_info',
        'change_record',
        'branchs',
        'financing_history',
        'core_team',
        'enterprise_business',
        'legal_proceedings',
        'court_notice',
        'dishonest_person',
        'person_subjected_execution',
        'abnormal_operation',
        'administrative_sanction',
        'serious_violation',
        'stock_ownership',
        'chattel_mortgage',
        'tax_notice',
        'bidding',
        'purchase_information',
        'tax_rating',
        'qualification_certificate',
        'trademark_information',
        'patent',
    ];
}