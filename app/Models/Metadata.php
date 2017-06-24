<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{

    protected $fillable = [
        'title',
        'description',
        'keywords'
    ];
    /**
     * Get all of the owning commentable models.
     */
    public function entities()
    {
        return $this->morphTo();
    }
}
