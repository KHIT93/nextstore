<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CheckoutTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_fill_in_a_billing_address()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 100]);
        $cart = Cart::create();
        $cart->addItem($product->id, 1);
        $cart = $cart->fresh();
        session(['cart_id' => $cart->id]);
    }

    /** @test */
    public function a_user_can_choose_an_existing_billing_address_that_is_assigned_to_their_account()
    {

    }

    /** @test */
    public function a_user_can_fill_in_a_shipping_address()
    {

    }

    /** @test */
    public function a_user_can_choose_an_existing_shipping_address_that_is_assigned_to_their_account()
    {

    }
}
