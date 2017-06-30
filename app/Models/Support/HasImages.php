<?php

namespace App\Models\Support;
use Illuminate\Http\UploadedFile;
use App\Models\Image;

trait HasImages
{
    /**
     * Get all of the post's comments.
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'entity');
    }

    public function storeImage(UploadedFile $file)
    {
        Image::store($file, $this);
        return $this;
    }
}
