<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tax;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\FreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManageTaxesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_cannot_access_taxs_through_the_webapi()
    {
        $this->expectException(AuthenticationException::class);
        $response = $this->getJson('/webapi/taxes');
    }

    /** @test */
    public function a_list_of_taxs_can_be_collected_from_the_webapi()
    {
        $this->signIn();
        $taxes = collect([Tax::create(['name' => 'Sales tax', 'value' => 15]), Tax::create(['name' => 'International sales tax', 'value' => 0])]);
        $response = $this->getJson('/webapi/taxes');
        $response->assertStatus(200);
        $responseData = $response->json();
        $this->assertCount($taxes->count(), $responseData);
    }

    /** @test */
    public function a_tax_can_be_created()
    {
        $this->signIn();
        $tax = new Tax(['name' => 'Sales tax', 'value' => 15]);

        $response = $this->json('PUT', '/webapi/taxes', $tax->toArray());

        $response->assertStatus(200);
        $response->assertSee($tax->name);

    }

    /** @test */
    public function a_single_tax_can_be_shown()
    {
        $this->signIn();
        $tax = Tax::create(['name' => 'Sales tax', 'value' => 15]);

        $response = $this->json('GET', '/webapi/taxes/'.$tax->id);

        $response->assertStatus(200);
        $response->assertSee($tax->name);
    }

    /** @test */
    public function a_single_tax_can_be_updated()
    {
        $this->signIn();
        $tax = Tax::create(['name' => 'Sales tax', 'value' => 15]);;

        $taxText = 'Updated text';
        $tax->name = $taxText;

        $response = $this->json('PATCH', '/webapi/taxes/'.$tax->id, $tax->toArray());

        $response->assertStatus(200);
        $response->assertSee($taxText);
    }

    /** @test */
    public function a_single_tax_can_be_deleted()
    {
        $this->signIn();
        $taxToDelete = Tax::create(['name' => 'International sales tax', 'value' => 0]);

        $taxToKeep = Tax::create(['name' => 'Sales tax', 'value' => 15]);

        $response = $this->json('DELETE', '/webapi/taxes/'.$taxToDelete->id);

        $this->getJson('/webapi/taxes')
             ->assertDontSee($taxToDelete->name)
             ->assertSee($taxToKeep->name);
    }
}
