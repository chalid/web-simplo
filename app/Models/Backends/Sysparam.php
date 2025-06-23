<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class Sysparam extends Model
{
    use HasFactory;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    
    protected $fillable = [
        'sgroup',
        'skey',
        'svalue',
        'lvalue',
    ];
}
