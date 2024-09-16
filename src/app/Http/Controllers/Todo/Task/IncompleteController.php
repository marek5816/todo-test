<?php


namespace App\Http\Controllers\Todo\Task;


use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Todo\TodoTask;
use App\Notifications\TaskNotification;
use App\Traits\Notification\NotifyTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncompleteController extends Controller
{
    use NotifyTask, Route;

    public function incomplete($id)
    {
        $task = TodoTask::findOrFail($id);

        $this->authorize('update', $task);

        $task->completed_at = null;
        $task->completed_by = null;
        $task->save();

        $taskUsers = $task->shares->pluck('id');
        $taskUsers[] = $task->creator->id;
        $this->notifyTaskUsers($task, $taskUsers, TaskNotification::TYPE_INCOMPLETE);

        return $this->redirectWithQuerySuccess('todo.task.list', 'Task incompleted successfully');
    }
}
