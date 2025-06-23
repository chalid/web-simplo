<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Motto extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'title',
        'description',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'meta_image',
        'meta_canonical',
        'meta_robots',
        'slug',
        'is_active',
    ];
}
