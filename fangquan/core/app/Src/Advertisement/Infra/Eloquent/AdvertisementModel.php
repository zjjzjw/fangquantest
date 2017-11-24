<?php namespace App\Src\Advertisement\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AdvertisementModel extends Model
{
    use SoftDeletes;

    protected $table = 'advertisement';

    protected $fillable = [
        'title',
        'image_id',
        'position',
        'type',
        'link',
        'sort',
        'status',
    ];
}