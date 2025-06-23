<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ExVessel extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'title',
        'description',
        'grt',
        'loa',
        'dwt',
        'year',
        'image',
        'vessel_type',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_author',
        'meta_image',
        'meta_canonical',
        'meta_robots',
        'slug',
        'is_sold',
        'is_active',
    ];

    public function images()
    {
        return $this->hasMany(ExVesselImage::class, 'ex_vessel_id');
    }

    public function vesselType()
    {
        return $this->hasOne(Sysparam::class, 'skey', 'vessel_type')
                    ->where('sgroup', 'vessel_type');
    }
}
