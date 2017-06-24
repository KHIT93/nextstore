<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Support\HasMetadata;

class Page extends Model
{
    use HasMetadata;

    protected $fillable = [
        'title',
        'body',
        'author_id',
        'published'
    ];

    protected $with = ['author', 'metadata'];

    /**
     * Gets the author of the node.
     * @return User
     */
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }
}
