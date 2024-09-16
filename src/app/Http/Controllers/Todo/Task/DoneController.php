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

class DoneController extends Controller
{
    use NotifyTask, Route;

    public function done($id)
    {
        $task = TodoTask::findOrFail($id);

        $this->authorize('update', $task);

        $task->completed_at = now();
        $task->completed_by = Auth::id();
        $task->save();

        $taskUsers = $task->shares->pluck('id');
        $taskUsers[] = $task->creator->id;
        $this->notifyTaskUsers($task, $taskUsers, TaskNotification::TYPE_DONE);

        return $this->redirectWithQuerySuccess('todo.task.list', 'Task done successfully');
    }
}
