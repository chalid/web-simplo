<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Article extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'article_category_id',
        'title',
        'description',
        'image',
        'meta_title',
        'meta_tag',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'meta_image',
        'meta_canonical',
        'meta_robots',
        'slug', // For SEO-friendly URLs
        'is_active',
    ];

    protected $casts = ['created_at' => 'datetime'];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
    }
}
