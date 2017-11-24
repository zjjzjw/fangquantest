<?php namespace App\Src\Loupan\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Src\Developer\Infra\Eloquent\DeveloperModel;

class LoupanDeveloperModel extends Model
{
    use SoftDeletes;

    protected $table = 'loupan_developer';

    protected $fillable = [
        'loupan_id',
        'developer_id',
    ];
}