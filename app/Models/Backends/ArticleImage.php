<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ArticleImage extends Model
{
    use RevisionableTrait;
    protected $table = 'article_images';
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'article_id',
        'uri',
        'is_default',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
