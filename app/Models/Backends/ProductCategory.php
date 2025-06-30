<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ProductCategory extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'title',
        'parent_id',
        'image',
        'meta_tag',
        'meta_image',
        'slug', // For SEO-friendly URLs
        'is_active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'product_category_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id', 'id');
    }
}
