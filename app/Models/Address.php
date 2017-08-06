<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
