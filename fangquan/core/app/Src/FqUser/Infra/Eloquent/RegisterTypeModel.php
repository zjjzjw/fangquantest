<?php
namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;

class RegisterTypeModel extends Model
{
    public $timestamps = false;

    protected $table = 'register_type';

    protected $fillable = [
        'name',
    ];

}