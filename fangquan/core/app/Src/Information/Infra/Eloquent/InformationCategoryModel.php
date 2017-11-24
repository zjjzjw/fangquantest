<?php

namespace App\Src\Information\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationCategoryModel extends Model
{
    use SoftDeletes;

    protected $table = 'information_category';

    protected $fillable = [
        'information_id',
        'category_id',
    ];

}