<?php

namespace App\Models;

use App\Models\Support\HasMetadata;
use App\Models\Support\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasMetadata, HasImages;
    protected $fillable = [
        'name',
        'teaser',
        'description',
        'body',
        'price',
        'image_id'
    ];

    protected $with = ['metadata', 'image'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'entity');
    }
}
