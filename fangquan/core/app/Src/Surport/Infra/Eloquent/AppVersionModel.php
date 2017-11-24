<?php
namespace App\Src\Surport\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AppVersionModel extends Model
{
    public $timestamps = false;

    protected $table = 'app_version';

}