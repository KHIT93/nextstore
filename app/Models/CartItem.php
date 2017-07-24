<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Product;
use App\Exceptions\InvalidCartItemException;

class CartItem extends Model
{
    protected $fillable = ['product_id', 'qty', 'cart_id'];

    protected $with = ['product'];

    public function calculateTotal()
    {
        $this->subtotal = $this->product->price * $this->qty;
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function save(array $options = [])
    {
        if($this->qty < 0)
        {
            throw new InvalidCartItemException('You are now allowed to add a negative quantity to the cart');
            return;
        }
        $this->calculateTotal();
        return parent::save($options);
    }

    public function getTaxesAttribute($value)
    {
        return $this->product->tax_value() * $this->qty;
    }

    public function getTotalAttribute($value)
    {
        return $this->subtotal + $this->taxes;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['taxes'] = $this->taxes;
        $data['subtotal_in_currency'] = money_format('%i', $this->subtotal / 100);
        $data['total_in_currency'] = money_format('%i', $this->total / 100);
        return $data;
    }
}
