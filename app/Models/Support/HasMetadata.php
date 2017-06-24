<?php

namespace App\Models\Support;

trait HasMetadata
{
    /**
     * Get all of the post's comments.
     */
    public function metadata()
    {
        return $this->morphOne('App\Models\Metadata', 'entity');
    }
}
