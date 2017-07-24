<?php

namespace App\Models;

use App\Models\Support\HasMetadata;
use App\Models\Support\HasImages;
use App\Models\CartItem;
use App\Models\Tax;
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
        'image_id',
        'tax_id',
        'category_id'
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

    public function cart_items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function tax_value()
    {
        if(!$this->tax)
        {
            return 0;
        }
        return $this->price * ($this->tax->value / 100);
    }

    public function getPriceFormattedAttribute($value)
    {
        return money_format('%i', $this->price / 100);
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['price_formatted'] = $this->price_formatted;
        return $data;
    }
}
