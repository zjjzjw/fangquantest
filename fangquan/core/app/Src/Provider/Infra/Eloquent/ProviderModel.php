<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider';


    protected $fillable = [
        'company_name',
        'brand_name',
        'patent_count',
        'favorite_count',
        'product_count',
        'project_count',
        'province_id',
        'city_id',
        'operation_address',
        'produce_province_id',
        'produce_city_id',
        'produce_address',
        'telphone',
        'fax',
        'service_telphone',
        'website',
        'operation_mode',
        'founding_time',
        'turnover',
        'registered_capital',
        'registered_capital_unit',
        'worker_count',
        'summary',
        'corp',
        'score_scale',
        'score_qualification',
        'score_credit',
        'score_innovation',
        'score_service',
        'contact',
        'integrity',
        'rank',
        'is_ad',
        'status',
        'company_type',
        'corp_phone',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider_pictures()
    {
        return $this->hasMany(ProviderPictureModel::class, 'provider_id', 'id');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provider_main_categories()
    {
        return $this->hasMany(ProviderMainCategoryModel::class, 'provider_id', 'id');
    }

    public function provider_certificate()
    {
        return $this->hasMany(ProviderCertificateModel::class, 'provider_id', 'id');
    }

    public function provider_domestic_imports()
    {
        return $this->hasMany(ProviderDomesticImportModel::class, 'provider_id', 'id');
    }

    public function provider_management_modes()
    {
        return $this->hasMany(ProviderManagementModeModel::class, 'provider_id', 'id');
    }

    public function brand_friends()
    {
        return $this->hasMany(BrandFriendModel::class, 'brand_id', 'id');
    }

}