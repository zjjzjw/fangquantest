<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MeasureunitModel extends Model
{
    use SoftDeletes;

    protected $table = 'measureunit';

    protected $fillable = [
        'name',
    ];
}