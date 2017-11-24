<?php
namespace App\Src\FqUser\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PlatformModel extends Model
{
    public $timestamps = false;

    protected $table = 'platform';

    protected $fillable = [
        'name',
    ];

}