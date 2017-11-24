<?php
namespace App\Src\Surport\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceModel extends Model
{
    use SoftDeletes;

    protected $table = 'resource';

    protected $fillable = [
        'bucket',
        'hash',
        'processed_hash',
        'mime_type',
        'desc',
    ];

}