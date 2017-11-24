<?php namespace App\Src\Developer\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeveloperModel extends Model
{
    use SoftDeletes;

    protected $table = 'developer';

    protected $fillable = [
        'name',
        'logo',
        'status',
        'rank',
    ];
}