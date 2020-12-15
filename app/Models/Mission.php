<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    use SoftDeletes;

    protected $hidden = 'deleted_at';

    protected $fillable = [
        'name',
        'flight'
    ];

    /**
     * Get the missions.
     */
    public function capsules()
    {
        return $this->belongsToMany(Capsule::class);
    }
}
