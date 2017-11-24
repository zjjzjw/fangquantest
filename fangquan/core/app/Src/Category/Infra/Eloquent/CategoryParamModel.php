<?php
namespace App\Src\Category\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryParamModel extends Model
{
    use SoftDeletes;

    protected $table = 'category_param';

    protected $fillable = [
        'category_id',
        'name',
    ];

}