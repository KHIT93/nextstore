<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Product;
use App\Models\Category;

class ProductsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function products_can_be_retrieved_from_their_category()
    {
        $category = create(Category::class);
        create(Product::class, ['category_id' => $category->id], 5);
        $this->assertCount(5, $category->fresh()->products);
    }
}
