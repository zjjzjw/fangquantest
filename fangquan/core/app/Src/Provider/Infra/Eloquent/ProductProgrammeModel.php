<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductProgrammeModel extends Model
{
    use SoftDeletes;

    protected $table = 'product_programme';

    protected $fillable = [
        'product_id',
        'programme_id',
    ];


}