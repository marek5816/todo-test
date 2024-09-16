<?php

use App\Models\Auth\User;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

Class T01_FillDbTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function fillDb()
    {
        $this->artisan('migrate:fresh');

        // Seedet je naduplikovany aby upravenie DatabaseSeeder.php neovlivnilo unit test
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@test.sk',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'test2',
            'email' => 'test2@test.sk',
            'password' => bcrypt('password'),
        ]);

        User::factory()->count(3)->create();
        TodoCategory::factory()->count(5)->create();
        TodoTask::factory()->count(15)->create()->each(function ($task, $index) {
            $categories = TodoCategory::inRandomOrder()->take(rand(0, 3))->pluck('id');
            $task->categories()->attach($categories);

            $users = User::where('id', '!=', $task->created_by)
                ->inRandomOrder()
                ->take(rand(0, 2))
                ->pluck('id');
            $task->shares()->attach($users);

            if ($index <= 4) {
                $task->completed_at = now();
                $task->completed_by = $task->created_by;
                $task->save();
            }

            if ($index >= 2 && $index <= 5) {
                $task->delete();
            }
        });
    }
}


