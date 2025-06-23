<?php

namespace App\Models\Backends;

use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class ClientModel extends Model
{
    use RevisionableTrait;

    protected $table = 'clients'; 
    protected $revisionEnabled = true;
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
    protected $historyLimit = 100; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'is_active',
    ];
}
