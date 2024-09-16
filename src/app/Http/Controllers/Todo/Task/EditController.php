<?php

namespace App\Http\Controllers\Todo\Task;


use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use App\Notifications\TaskNotification;
use App\Traits\Notification\NotifyTask;
use App\Traits\Todo\Task\RecordOwnershipTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    use NotifyTask;

    public function view($id)
    {
        $task = TodoTask::findOrFail($id);

        $this->authorize('update', $task);

        $categories = TodoCategory::all();
        $users = User::where('id', '!=', auth()->id())->get();
        return view('todo.task.edit', compact('task', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $task = TodoTask::findOrFail($id);

        $this->authorize('update', $task);

        $validateRules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'nullable|array'
        ];

        if (!$task->isSharedWithCurrentUser()) {
            $validateRules['shares'] = 'nullable|array';
        }

        $request->validate($validateRules);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->categories()->sync($request->categories);

        if (!$task->isSharedWithCurrentUser()) {
            $task->shares()->sync($request->shares);
        }

        $task->save();

        $this->notifyChange($task, $request);

        return redirect()->route('todo.task.list')->with('success', 'Task updated successfully');
    }

    private function notifyChange(TodoTask $task, Request $request) {
        $requestShares = collect($request->shares);
        $taskUsers = $task->shares->pluck('id');
        $taskUsers[] = $task->creator->id;
        if ($task->isCreatedByCurrentUser()) {
            $newShareUsers = $requestShares->diff($taskUsers);
            $removedShareUsers = $taskUsers->diff($requestShares);
            $commonShareUsers = $requestShares->intersect($taskUsers);

            $this->notifyTaskUsers($task, $newShareUsers, TaskNotification::TYPE_SHARED);
            $this->notifyTaskUsers($task, $removedShareUsers, TaskNotification::TYPE_UNSHARED);
            $this->notifyTaskUsers($task, $commonShareUsers, TaskNotification::TYPE_UPDATED);
        } else if ($task->isSharedWithCurrentUser()) {
            $this->notifyTaskUsers($task, $taskUsers, TaskNotification::TYPE_UPDATED);
        }
    }
}
