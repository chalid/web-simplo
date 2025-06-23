<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;
use \Venturecraft\Revisionable\RevisionableTrait;

class PermissionModel extends Permission
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    
    public function children()
    {
        return $this->hasMany('App\Models\Backends\PermissionModel', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Backends\PermissionModel', 'parent_id', 'id');
    }
}
