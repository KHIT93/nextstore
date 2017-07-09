<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Software']);
        Category::create(['name' => 'Hardware']);
        Category::create(['name' => 'Processors', 'parent_id' => Category::whereName('Hardware')->first()->id]);
        Category::create(['name' => 'Intel', 'parent_id' => Category::whereName('Processors')->first()->id]);
        Category::create(['name' => 'AMD', 'parent_id' => Category::whereName('Processors')->first()->id]);
        Category::create(['name' => 'Cases', 'parent_id' => Category::whereName('Hardware')->first()->id]);
        Category::create(['name' => 'Packages']);
    }
}
