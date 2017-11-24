<?php

namespace App\Src\Theme\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThemeModel extends Model
{
    use SoftDeletes;

    protected $table = 'theme';


    protected $fillable = [
        'name',
        'type',
        'order',
        'created_user_id',
    ];

}