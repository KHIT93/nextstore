<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Tax;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartTaxCalculationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_cart_item_has_a_tax_value()
    {
        $tax = Tax::create(['name' => 'Sales tax', 'value' => 25]);
        $product1 = create(Product::class, ['id' => 123, 'price' => 100]);
        $tax->products()->save($product1);
        $product2 = create(Product::class, ['id' => 456, 'price' => 200]);
        $tax->products()->save($product2);
        $product1 = $product1->fresh();
        $product2 = $product2->fresh();
        $cart = Cart::create();
        $cart->addItem($product1->id, 1);
        $cart->addItem($product2->id, 2);
        $cart = $cart->fresh();
        $this->assertEquals(25, $cart->cart_items[0]->taxes);
        $this->assertEquals(100, $cart->cart_items[1]->taxes);
    }
}
