<?php

namespace App\Src\Tag\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagModel extends Model
{
    use SoftDeletes;

    protected $table = 'tag';

    protected $dates = [
        'publish_at',
    ];

    protected $fillable = [
        'name',
        'created_user_id',
        'order',
        'type',
    ];

}