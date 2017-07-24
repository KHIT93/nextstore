<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    protected $with = ['cart_items'];

    public function cart_items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function addItem($product_id, $qty = 1)
    {
        Product::findOrFail($product_id);
        if($this->cart_items->contains('product_id', $product_id))
        {
            $cart_item = $this->cart_items->where('product_id', '=', $product_id)->first();
            $current_total = $cart_item->subtotal;
            $cart_item->qty += $qty;
            $cart_item->save();
            $this->subtotal += $cart_item->subtotal - $current_total;
            $this->save();

        }
        else
        {
            $cart_item =$this->cart_items()->save(new CartItem(['product_id' =>  $product_id, 'qty' => $qty]));
            $this->subtotal += $cart_item->subtotal;
            $this->save();

        }
    }

    public function updateItem($product_id, $qty = 1)
    {
        if($this->cart_items->contains('product_id', $product_id))
        {
            $cart_item = $this->cart_items->where('product_id', '=', $product_id)->first();
            $current_total = $cart_item->subtotal;
            $cart_item->qty = $qty;
            $cart_item->save();
            $this->subtotal += $cart_item->subtotal - $current_total;
            $this->save();
        }
    }

    public function deleteItem($product_id)
    {
        if($this->cart_items->contains('product_id', $product_id))
        {
            $item = $this->cart_items->where('product_id', '=', $product_id)->first();
            $total = $item->subtotal;
            $item->delete();
            $this->subtotal -= $total;
            $this->save();
        }
    }



    public function getTotalAttribute($value)
    {
        return $this->subtotal + $this->cart_items->sum('taxes') + $this->shipping;
    }

    public function getShippingAttribute($value)
    {
        return 0;
    }

    public function getTaxesAttribute($value)
    {
        return $this->cart_items->sum('taxes');
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['taxes'] = $this->taxes;
        $data['total'] = $this->total;
        $data['shipping'] = 0;
        $data['subtotal_in_currency'] = money_format('%i', $this->subtotal / 100);
        $data['total_in_currency'] = money_format('%i', $this->total / 100);
        $data['taxes_in_currency'] = money_format('%i', $data['taxes'] / 100);
        $data['shipping_in_currency'] = money_format('%i', $data['shipping'] / 100);
        return $data;
    }
}
