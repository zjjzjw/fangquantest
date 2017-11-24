<?php
namespace App\Src\Category\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeModel extends Model
{
    use SoftDeletes;

    protected $table = 'attribute';

    protected $fillable = [
        'name',
        'order',
        'category_id',
    ];

    public function attribute_values(){
        return $this->hasMany(AttributeValueModel::class, 'attribute_id', 'id');
    }
}