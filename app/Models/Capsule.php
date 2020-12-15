<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capsule extends Model
{
    use SoftDeletes;

    protected $hidden = 'deleted_at';
    
    protected $fillable = [
        'capsule_serial', 
        'capsule_id', 
        'status', 
        'original_launch', 
        'original_launch_unix', 
        'landings', 
        'type',
        'details',
        'reuse_count'
    ];

    protected $dates = [
        'original_launch', 
        'original_launch_unix'
    ];

    /**
     * Get the capsules.
     */
    public function missions()
    {
        return $this->belongsToMany(Mission::class);
    }

}
