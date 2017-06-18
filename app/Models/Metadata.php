<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    /**
     * Get all of the owning commentable models.
     */
    public function entities()
    {
        return $this->morphTo();
    }
}
