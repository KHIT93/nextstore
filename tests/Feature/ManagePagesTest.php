<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\FreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManagePagesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_cannot_access_pages_through_the_webapi()
    {
        $this->expectException(AuthenticationException::class);
        $response = $this->getJson('/webapi/pages');
    }

    /** @test */
    public function a_list_of_pages_can_be_collected_from_the_webapi()
    {
        $this->signIn();
        $pages = create('App\Models\Page', [], 2);
        $response = $this->getJson('/webapi/pages');
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertCount($pages->count(), $responseData);
    }

    /** @test */
    public function a_page_can_be_created()
    {
        $this->signIn();
        $page = make('App\Models\Page');

        $response = $this->json('PUT', '/webapi/pages', $page->toArray());

        $response->assertStatus(200);
        $response->assertSee($page->title);
    }

    /** @test */
    public function a_single_page_can_be_shown()
    {
        $this->signIn();
        $page = create('App\Models\Page');

        $response = $this->json('GET', '/webapi/pages/'.$page->id);

        $response->assertStatus(200);
        $response->assertSee($page->title);
    }

    /** @test */
    public function a_single_page_can_be_updated()
    {
        $this->signIn();
        $page = create('App\Models\Page');

        $pageText = 'Updated text';
        $page->body = $pageText;

        $response = $this->json('PATCH', '/webapi/pages/'.$page->id, $page->toArray());

        $response->assertStatus(200);
        $response->assertSee($pageText);
    }

    /** @test */
    public function a_single_product_can_be_deleted()
    {
        $this->signIn();
        $pageToDelete = create('App\Models\Page');

        $pageToKeep = create('App\Models\Page');

        $response = $this->json('DELETE', '/webapi/pages/'.$pageToDelete->id);

        $this->getJson('/webapi/pages')
             ->assertDontSee($pageToDelete->title)
             ->assertSee($pageToKeep->title);
    }
}
