<?php
namespace App\Src\Category\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValueModel extends Model
{
    use SoftDeletes;

    protected $table = 'attribute_value';

    protected $fillable = [
        'attribute_id',
        'name',
        'order',
    ];

}