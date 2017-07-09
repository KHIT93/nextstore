<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class)->create(['name' => 'Computer case', 'category_id' => Category::whereName('Cases')->first()->id]);
        factory(Product::class)->create(['name' => 'Fancy computer case', 'category_id' => Category::whereName('Cases')->first()->id]);
        factory(Product::class)->create(['name' => 'Core i7 7700K', 'category_id' => Category::whereName('Intel')->first()->id]);
        factory(Product::class)->create(['name' => 'Core i5 6600K', 'category_id' => Category::whereName('Intel')->first()->id]);
        factory(Product::class)->create(['name' => 'Ryzen R7-1800X', 'category_id' => Category::whereName('AMD')->first()->id]);
        factory(Product::class)->create(['name' => 'Ryzen Threadripper', 'category_id' => Category::whereName('AMD')->first()->id]);
        factory(Product::class)->create(['name' => 'Xeon E3-1220V5', 'category_id' => Category::whereName('Intel')->first()->id]);
        factory(Product::class)->create(['name' => 'Xeon E5-2699V3', 'category_id' => Category::whereName('Intel')->first()->id]);
        factory(Product::class)->create(['name' => 'Windows 10 Pro', 'category_id' => Category::whereName('Software')->first()->id]);
        factory(Product::class)->create(['name' => 'macOS High Sierra (10.13) Install USB', 'category_id' => Category::whereName('Software')->first()->id]);
        factory(Product::class)->create(['name' => 'Windows 10 Home Install USB', 'category_id' => Category::whereName('Software')->first()->id]);
    }
}
