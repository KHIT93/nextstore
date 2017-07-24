<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Tax extends Model
{
    protected $fillable = ['name', 'value'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
