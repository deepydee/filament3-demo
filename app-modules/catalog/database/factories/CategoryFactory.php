<?php

namespace Modules\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Catalog\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'is_active' => fake()->boolean(),
            'url_key' => fake()->slug(2),
            'url_path' => fake()->slug(2),
            'seo_name' => fake()->sentence(),
            'meta_title' => fake()->sentence(),
            'meta_keywords' => fake()->sentence(),
            'meta_description' => fake()->sentence(),
        ];
    }
}
