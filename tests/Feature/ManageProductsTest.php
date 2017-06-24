<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\FreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageProductsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_list_of_products_can_be_collected_from_the_webapi()
    {
        $products = create('App\Models\Product', [], 2);
        $response = $this->getJson('/webapi/products');
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertCount($products->count(), $responseData);
    }

    /** @test */
    public function a_product_can_be_created()
    {
        $product = make('App\Models\Product');

        $response = $this->json('PUT', '/webapi/products', $product->toArray());

        $response->assertStatus(200);
        $response->assertSee($product->name);

    }

    /** @test */
    public function a_single_product_can_be_shown()
    {
        $product = create('App\Models\Product');

        $response = $this->json('GET', '/webapi/products/'.$product->id);

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function a_single_product_can_be_updated()
    {
        $product = create('App\Models\Product');

        $productText = 'Updated text';
        $product->name = $productText;

        $response = $this->json('PATCH', '/webapi/products/'.$product->id, $product->toArray());

        $response->assertStatus(200);
        $response->assertSee($productText);
    }

    /** @test */
    public function a_single_product_can_be_deleted()
    {
        $productToDelete = create('App\Models\Product');

        $productToKeep = create('App\Models\Product');

        $response = $this->json('DELETE', '/webapi/products/'.$productToDelete->id);

        $this->getJson('/webapi/products')
             ->assertDontSee($productToDelete->name)
             ->assertSee($productToKeep->name);
    }
}
