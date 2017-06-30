<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = [
        'path',
        'location',
        'entity_type',
        'entity_id'
    ];

    /**
     * Get all of the owning commentable models.
     */
    public function entities()
    {
        return $this->morphTo();
    }

    public static function store(UploadedFile $file, Model $model)
    {
        $path = $file->store("images/{$model->getTable()}/{$model->getKey()}");
        return self::create([
            'path' => $path,
            'location' => config('filesystems.default'),
            'entity_id' => $model->getKey(),
            'entity_type' => $model->getMorphClass()
        ]);
    }

    public function delete()
    {
        Storage::delete($this->path);
        return parent::delete();
    }
}
