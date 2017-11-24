<?php namespace App\Src\Provider\Infra\Eloquent;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderFriendModel extends Model
{
    use SoftDeletes;

    protected $table = 'provider_friend';

    protected $fillable = [
        'provider_id',
        'name',
        'logo',
        'status',
        'link',
        'created_at'
    ];

}