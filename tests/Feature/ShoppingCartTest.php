<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\Tax;
use App\Exceptions\InvalidCartItemException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShoppingCartTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_add_a_product_to_the_cart()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 1])->assertStatus(200);
        $response = $this->getJson(route('cart.show'));
        $response->assertStatus(200);
        $response->assertSessionHas('cart_id');
        $this->assertEquals(500, $response->json()['subtotal']);
    }

    /** @test */
    public function a_user_cannot_add_a_negative_qty_to_the_cart()
    {
        $this->expectException(InvalidCartItemException::class);
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $data = $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => -1]);
        $response = $this->getJson(route('cart.show'));
    }

    /** @test */
    public function a_users_shopping_cart_is_preserved_upon_login()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $user = create(User::class);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 1]);
        $response = $this->getJson(route('cart.show'));

        //Check that the cart total is correct before we log in.
        $this->assertEquals(500, $response->json()['subtotal']);

        $this->signIn($user);
        $response = $this->getJson(route('cart.show'));
        //Check that the cart total is correct after logging in.
        $this->assertEquals(500, $response->json()['subtotal']);
    }

    /** @test */
    public function a_users_shopping_cart_is_preserved_upon_registration()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 1]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(500, $response->json()['subtotal']);
        $this->post(route('register'), ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => 'P@ssw0rd', 'password_confirmation' => 'P@ssw0rd']);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(500, $response->json()['subtotal']);
    }

    /** @test */
    public function a_user_cannot_add_a_nonexisting_product_to_the_cart()
    {
        $this->expectException(ModelNotFoundException::class);
        $response = $this->json('POST', route('cart.store'), ['product_id' => 45624, 'qty' => 1]);
    }

    /** @test */
    public function the_quantity_of_a_cart_item_can_be_increased_and_cart_is_recalculated()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 1]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(500, $response->json()['subtotal']);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 1]);
        $response = $this->getJson(route('cart.show'));
        $this->assertCount(1, $response->json()['cart_items']);
        $this->assertEquals(1000, $response->json()['subtotal']);
    }

    /** @test */
    public function the_quantity_of_a_cart_item_can_be_decreased_and_cart_is_recalculated()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 2]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(1000, $response->json()['subtotal']);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => -1]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(500, $response->json()['subtotal']);
    }

    /** @test */
    public function the_quantity_of_cart_item_can_be_updated()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 2]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(1000, $response->json()['subtotal']);
        $this->json('PATCH', route('cart.item.update'), ['product_id' => $product->id, 'qty' => 6]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(3000, $response->json()['subtotal']);
    }

    /** @test */
    public function a_cart_item_can_be_removed_from_the_cart()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 500]);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 2]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(1000, $response->json()['subtotal']);
        $this->json('DELETE', route('cart.item.delete'), ['product_id' => $product->id]);
        $response = $this->getJson(route('cart.show'));
        $this->assertEquals(0, $response->json()['subtotal']);
    }

    /** @test */
    public function a_cart_has_taxes()
    {
        $product = create(Product::class, ['id' => 123, 'price' => 100]);
        Tax::create(['name' => 'Sales tax', 'value' => 25])->products()->save($product);
        $this->json('POST', route('cart.store'), ['product_id' => $product->id, 'qty' => 1]);
        $this->assertEquals(25, $this->getJson(route('cart.show'))->json()['taxes']);
    }
}
