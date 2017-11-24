<?php

namespace App\Src\Information\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationThemeModel extends Model
{
    use SoftDeletes;

    protected $table = 'information_theme';

    protected $fillable = [
        'information_id',
        'theme_id',
    ];

}