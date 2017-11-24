<?php namespace App\Src\Role\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDataModel extends Model
{
    use SoftDeletes;

    protected $table = 'user_data';

    protected $fillable = [
        'user_id',
        'data_id',
        'data_type',
    ];

}