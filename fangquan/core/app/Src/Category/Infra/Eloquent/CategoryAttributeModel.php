<?php
namespace App\Src\Category\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryAttributeModel extends Model
{
    use SoftDeletes;

    protected $table = 'category_attribute';

    protected $fillable = [
        'category_id',
        'attribute_id',
    ];

}