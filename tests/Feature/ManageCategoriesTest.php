<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\FreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Auth\AuthenticationException;

class ManageCategoriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_cannot_access_categories_through_the_webapi()
    {
        $this->expectException(AuthenticationException::class);
        $response = $this->getJson('/webapi/categories');
    }

    /** @test */
    public function a_list_of_categories_can_be_collected_from_the_webapi()
    {
        $this->signIn();
        $categories = create('App\Models\Category', [], 2);
        $response = $this->getJson('/webapi/categories');
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertCount($categories->count(), $responseData);
    }

    /** @test */
    public function a_category_can_be_created()
    {
        $this->signIn();
        $category = make('App\Models\Category');

        $response = $this->json('PUT', '/webapi/categories', $category->toArray());

        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    /** @test */
    public function a_single_category_can_be_shown()
    {
        $this->signIn();
        $category = create('App\Models\Category');

        $response = $this->json('GET', '/webapi/categories/'.$category->id);

        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    /** @test */
    public function a_single_category_can_be_updated()
    {
        $this->signIn();
        $category = create('App\Models\Category');

        $categoryText = 'Updated text';
        $category->name = $categoryText;

        $response = $this->json('PATCH', '/webapi/categories/'.$category->id, $category->toArray());

        $response->assertStatus(200);
        $response->assertSee($categoryText);
    }
}
