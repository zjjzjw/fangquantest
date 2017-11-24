<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeveloperProjectContactVisitLogModel extends Model
{
    use SoftDeletes;

    protected $table = 'project_contact_visit_log';

    protected $fillable = [
        'user_id',
        'developer_project_id',
        'role_type',
        'role_id',
    ];
    
}