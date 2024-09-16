<?php

namespace Database\Factories\Todo;

use App\Models\Todo\TodoCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TodoCategoryFactory extends Factory
{
    protected $model = TodoCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(1, true)
        ];
    }
}
