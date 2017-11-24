<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperProjectContactModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer_project_contact';

    protected $fillable = [
        'developer_project_id',
        'type',
        'sort',
        'company_name',
        'contact_name',
        'job',
        'address',
        'telphone',
        'mobile',
        'remark',
    ];
}