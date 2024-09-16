<?php


use App\Models\Auth\User;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

Class T03_FullTodoTest extends TestCase
{
    /** @test */
    public function fullTodoTest()
    {
        $this->creatingCategory();
        $this->creatingTask();
        $this->editingTask();
        $this->complitingIncomplitingTask();
        $this->readNotifications();
        $this->deletingRestoringTask();
        $this->editingCategory();
        $this->permissions();
    }

    private function creatingCategory() {
        $user = User::where('email', 'unit@unit.sk')->first();
        $this->actingAs($user);

        $response = $this->post(route('todo.category.create', [], false), [
            'name' => 'unitCategory'
        ]);
        $response->assertRedirect(route('todo.category.list', [], false));
        $response->assertSessionHas('success', 'Category created successfully!');

        $category = TodoCategory::where('name', 'unitCategory')->first();
        $this->assertNotNull($category);
    }

    private function creatingTask() {
        $user = User::where('email', 'unit@unit.sk')->first();
        $this->actingAs($user);

        $shares = [
            User::where('name', 'test')->first()->id,
            User::where('name', 'test2')->first()->id
        ];
        $category = TodoCategory::where('name', 'unitCategory')->first()->id;

        $response = $this->post(route('todo.task.create', [], false), [
            'name' => 'unitTaskName',
            'description' => 'unitTaskDescription',
            'categories' => [
                $category
            ],
            'shares' => $shares
        ]);
        $response->assertRedirect(route('todo.task.list', [], false));
        $response->assertSessionHas('success', 'Task created successfully!');

        $task = TodoTask::where('name', 'unitTaskName')->where('description', 'unitTaskDescription')->first();

        $this->assertNotNull($task);
        $this->assertTrue($task->categories->contains('id', $category));
        $this->assertTrue($task->shares->pluck('id')->contains(fn($id) => in_array($id, $shares)));

        $user = User::where('name', 'test')->first();
        $this->assertCount(1, $user->notifications);
    }

    private function editingTask() {
        $user = User::where('email', 'unit@unit.sk')->first();
        $this->actingAs($user);

        $editTask = TodoTask::where('name', 'unitTaskName')->first()->id;

        $categories = TodoCategory::inRandomOrder()->take(3)->pluck('id')->toArray();
        $shares = User::whereNotIn('name', ['test', 'unit'])->inRandomOrder()->take(2)->pluck('id')->toArray();

        $response = $this->patch(route('todo.task.update', ['id' => $editTask], false), [
            'name' => 'unitTaskName',
            'description' => 'unitTaskDescription',
            'categories' => $categories,
            'shares' => $shares,
        ]);
        $response->assertRedirect(route('todo.task.list', [], false));
        $response->assertSessionHas('success', 'Task updated successfully');

        $task = TodoTask::where('name', 'unitTaskName')->where('description', 'unitTaskDescription')->first();

        $this->assertNotNull($task);
        $this->assertTrue($task->categories->pluck('id')->contains(fn($id) => in_array($id, $categories)));
        $this->assertTrue($task->shares->pluck('id')->contains(fn($id) => in_array($id, $shares)));

        $user = User::where('name', 'test')->first();
        $this->assertCount(2, $user->notifications);
    }

    private function complitingIncomplitingTask() {
        $user = User::where('email', 'unit@unit.sk')->first();
        $this->actingAs($user);

        $task = TodoTask::where('name', 'unitTaskName')->where('description', 'unitTaskDescription')->first();

        $response = $this->patch(route('todo.task.done', ['id' => $task->id], false));
        $response->assertSessionHas('success', 'Task done successfully');

        $task->refresh();
        $this->assertNotNull($task->completed_at);

        $response = $this->patch(route('todo.task.incomplete', ['id' => $task->id], false));
        $response->assertSessionHas('success', 'Task incompleted successfully');

        $task->refresh();
        $this->assertNull($task->completed_at);
    }

    private function readNotifications() {
        $user = User::where('email', 'test@test.sk')->first();
        $this->actingAs($user);

        $this->get(route('notification.list', [], false));

        $user = User::where('name', 'test')->first();
        $unreadNotifications = $user->notifications()->whereNull('read_at')->get();
        $this->assertCount(0, $unreadNotifications);
    }

    private function deletingRestoringTask() {
        $user = User::where('email', 'unit@unit.sk')->first();
        $this->actingAs($user);

        $task = TodoTask::where('name', 'unitTaskName')->where('description', 'unitTaskDescription')->first();

        $response = $this->delete(route('todo.task.delete', ['id' => $task->id], false));
        $response->assertSessionHas('success', 'Task deleted successfully');

        $task->refresh();
        $this->assertSoftDeleted('todo_tasks', ['id' => $task->id]);

        $response = $this->patch(route('todo.task.restore', ['id' => $task->id], false));
        $response->assertSessionHas('success', 'Task restored successfully');

        $task->refresh();
        $this->assertTrue($task->trashed() === false);
    }

    private function editingCategory() {
        $user = User::where('email', 'unit@unit.sk')->first();
        $this->actingAs($user);

        $category = TodoCategory::where('name', 'unitCategory')->first()->id;

        $response = $this->patch(route('todo.category.update', ['id' => $category], false), [
            'name' => 'unitCategoryEdited'
        ]);
        $response->assertRedirect(route('todo.category.list', [], false));
        $response->assertSessionHas('success', 'Category updated successfully');

        $task = TodoCategory::where('name', 'unitCategoryEdited')->first();

        $this->assertNotNull($task);
    }

    private function permissions() {
        $user = User::where('email', 'test@test.sk')->first();
        $this->actingAs($user);

        $task = TodoTask::where('name', 'unitTaskName')->where('description', 'unitTaskDescription')->first();

        $response = $this->delete(route('todo.task.delete', ['id' => $task->id], false));
        $response->assertStatus(403);

        $response = $this->patch(route('todo.task.restore', ['id' => $task->id], false));
        $response->assertStatus(403);

        $response = $this->patch(route('todo.task.edit', ['id' => $task->id], false));
        $response->assertStatus(403);

        $response = $this->patch(route('todo.task.done', ['id' => $task->id], false));
        $response->assertStatus(403);

        $response = $this->patch(route('todo.task.incomplete', ['id' => $task->id], false));
        $response->assertStatus(403);
    }
}
