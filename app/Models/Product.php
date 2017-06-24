<?php

namespace App\Models;

use App\Models\Support\HasMetadata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasMetadata;
    protected $fillable = [
        'name',
        'teaser',
        'description',
        'body',
        'price',
        'image_path'
    ];

    protected $with = ['metadata'];
}
