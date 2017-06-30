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
        'image_path'
    ];

    protected $with = ['metadata', 'images'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
