<?php

namespace App\Models\Support;

trait HasMetadata
{
    /**
     * Get all of the post's comments.
     */
    public function metadata()
    {
        return $this->morphMany('App\Models\Metadata', 'entity');
    }
}
