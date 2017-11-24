<?php namespace App\Src\Developer\Infra\Eloquent;

use App\Src\Product\Infra\Eloquent\ProductCategoryModel;
use App\Src\Project\Infra\Eloquent\ProjectCategoryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project';

    protected $dates = [
        'time',
        'time_start',
        'time_end',
    ];

    protected $fillable = [
        'name',
        'time',
        'developer_id',
        'project_stage_id',
        'is_great',
        'developer_type',
        'province_id',
        'city_id',
        'address',
        'cost',
        'views',
        'type',
        'project_category',
        'time_start',
        'time_end',
        'stage_design',
        'stage_build',
        'stage_decorate',
        'floor_space',
        'floor_numbers',
        'investments',
        'heating_mode',
        'wall_materials',
        'has_decorate',
        'has_airconditioner',
        'has_steel',
        'has_elevator',
        'summary',
        'status',
        'is_ad',
        'source',
        'contacts_email',
        'contacts_address',
        'contacts_phone',
        'contacts',
        'area',
        'other',
        'bidding_type',
        'deadline_for_registration',
    ];


    /**
     * 项目产品分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product_categories()
    {
        return $this->belongsToMany(ProductCategoryModel::class, 'developer_project_category', 'developer_project_id', 'product_category_id')->withTimestamps();
    }

    /**
     * 项目类型
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function project_categories()
    {
        return $this->hasMany(DeveloperProjectCategoryTypeModel::class, 'project_id', 'id');
    }


    /**
     * 项目项目分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function developer_project_categories()
    {
        return $this->belongsToMany(ProjectCategoryModel::class, 'developer_project_has_project_category', 'developer_project_id', 'project_category_id')->withTimestamps();
    }


}






