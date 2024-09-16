<?php

namespace Database\Factories\Todo;

use App\Models\Auth\User;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TodoTaskFactory extends Factory
{
    protected $model = TodoTask::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->words(5, true),
            'created_by' => User::inRandomOrder()->first()->id
        ];
    }
}
