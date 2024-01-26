<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rootCategory = Category::factory()->create([
            'name' => 'Каталог',
            'parent_id' => null,
            'level' => 0,
        ]);

        $this->generateCategories(level: 1, parentId: $rootCategory->id, maxLevels: 3);
    }


    private function generateCategories($level, $parentId, $maxLevels)
    {
        $categories = [];

        // Create categories for current level
        for ($i = 1; $i <= 10; $i++) {
            $category = Category::factory()->create([
                'parent_id' => $parentId,
                'level' => $level,
            ]);

            // Recurse if we haven't reached max levels
            if ($level < $maxLevels) {
                $this->generateCategories($level + 1, $category->id, $maxLevels);
            }

            Product::factory(10)->create(['category_id' => $category->id]);
        }
    }
}
