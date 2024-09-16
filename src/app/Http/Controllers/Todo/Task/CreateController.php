<?php


namespace App\Http\Controllers\Todo\Task;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoTask;
use App\Notifications\TaskNotification;
use App\Traits\Notification\NotifyTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    use NotifyTask, Route;

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'nullable|array',
            'shares' => 'nullable|array'
        ]);

        $task = TodoTask::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => Auth::id(),
            'completed_by' => null
        ]);

        $task->categories()->attach($request->categories);
        $task->shares()->attach($request->shares);
        $this->notifyTaskUsers($task, $request->shares, TaskNotification::TYPE_DONE);

        return $this->redirectWithQuerySuccess('todo.task.list', 'Task created successfully!');
    }
}
