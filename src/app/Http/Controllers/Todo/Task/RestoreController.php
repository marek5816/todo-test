<?php


namespace App\Http\Controllers\Todo\Task;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoTask;
use App\Notifications\TaskNotification;
use App\Traits\Notification\NotifyTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoreController extends Controller
{
    use NotifyTask, Route;

    public function restore($id)
    {
        $task = TodoTask::withTrashed()->findOrFail($id);

        $this->authorize('restore', $task);

        $task->restore();

        $taskUsers = $task->shares->pluck('id');
        $taskUsers[] = $task->creator->id;
        $this->notifyTaskUsers($task, $taskUsers, TaskNotification::TYPE_RESTORED);

        return $this->redirectWithQuerySuccess('todo.task.list', 'Task restored successfully');
    }
}
