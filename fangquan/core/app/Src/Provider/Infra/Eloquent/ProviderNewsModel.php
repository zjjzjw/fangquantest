<?php namespace App\Src\Provider\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderNewsModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_news';

    protected $fillable = [
        'provider_id',
        'title',
        'content',
        'status',
    ];
}