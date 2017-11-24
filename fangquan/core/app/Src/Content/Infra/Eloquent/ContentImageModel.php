<?php namespace App\Src\Content\Infra\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContentImageModel extends Model
{
    use SoftDeletes;

    protected $table = 'content_image';


    protected $fillable = [
        'content_id',
        'image_id',
    ];

    public function content()
    {
        return $this->belongsTo(ContentModel::class, 'content_id', 'id');
    }
}