<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ArticleCategory extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'article_category_id');
    }
}
