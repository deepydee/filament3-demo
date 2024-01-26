<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Catalog\Models\Product;
use Modules\Catalog\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        Tag::factory(10)
            ->create()
            ->each(fn ($tag) => $tag->products()->attach($products->random(3)));
    }
}
