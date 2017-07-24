<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Exceptions\InvalidCartItemException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_shopping_cart_total_is_calculated_when_an_item_is_added_to_the_cart()
    {
        $cart = Cart::create();
        $product = create(Product::class, ['price' => 100]);
        $cart->addItem($product->id, 1);
        //Check the the current in-memory object has the correct total
        $this->assertEquals(100, $cart->total);
        //Check that the cart in the database has the correct total
        $this->assertEquals(100, $cart->fresh()->total);
    }

    /** @test */
    public function a_negative_quantity_cannot_be_added_to_the_cart()
    {
        $this->expectException(InvalidCartItemException::class);
        $cart = Cart::create();
        $product = create(Product::class, ['price' => 100]);
        $cart->addItem($product->id, -1);
    }

    /** @test */
    public function the_quantity_increases_when_the_same_product_is_added_more_than_once()
    {
        $cart = Cart::create();
        $product = create(Product::class, ['price' => 100]);
        $cart->addItem($product->id, 1);
        $cart = $cart->fresh();
        $this->assertEquals(100, $cart->total);
        $cart->addItem($product->id, 1);
        $items = CartItem::where('product_id', '=', $product->id)->where('cart_id', '=', $cart->id)->get();
        $this->assertCount(1, $items);
        $this->assertEquals(200, $cart->fresh()->total);
    }

    /** @test */
    public function the_cart_can_update_the_qty_of_a_cart_item()
    {
        $cart = Cart::create();
        $product = create(Product::class, ['price' => 100]);
        $cart->addItem($product->id, 1);
        $cart = $cart->fresh();
        $this->assertEquals(100, $cart->fresh()->total);
        $cart->updateItem($product->id, 6);
        $this->assertEquals(600, $cart->fresh()->total);
    }

    /** @test */
    public function the_cart_can_remove_a_cart_item()
    {
        $cart = Cart::create();
        $product = create(Product::class, ['price' => 100]);
        $cart->addItem($product->id, 6);
        $this->assertEquals(600, $cart->fresh()->total);
        $cart->fresh()->deleteItem($product->id);
        $this->assertEquals(0, $cart->fresh()->total);
    }
}
