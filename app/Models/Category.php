<?php

namespace App\Models;

use App\Models\Support\HasMetadata;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasMetadata;
    protected $fillable = [
        'name',
        'parent_id',
        'body'
    ];

    protected $with = ['metadata'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function hasChildren()
    {
        return $this->chilren->count();
    }

}
