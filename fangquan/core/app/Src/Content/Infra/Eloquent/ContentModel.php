<?php namespace App\Src\Content\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContentModel extends Model
{
    use SoftDeletes;

    protected $table = 'content';

    protected $dates = [
        'publish_time',
    ];

    protected $fillable = [
        'title',
        'author',
        'content',
        'remake',
        'url',
        'audio_title',
        'audio',
        'type',
        'is_timing_publish',
        'publish_time',
        'status',
    ];

    public function content_images()
    {
        return $this->hasMany(ContentImageModel::class, 'content_id', 'id');
    }
}