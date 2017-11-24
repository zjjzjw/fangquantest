<?php namespace App\Src\Role\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WagePasswordModel extends Model
{
    use SoftDeletes;

    protected $table = 'wage_password';


    protected $fillable = [
        'user_id',
        'password',
    ];


}