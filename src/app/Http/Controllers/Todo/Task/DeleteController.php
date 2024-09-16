<?php


namespace App\Http\Controllers\Todo\Task;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoTask;
use App\Notifications\TaskNotification;
use App\Traits\Notification\NotifyTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    use NotifyTask, Route;

    public function delete($id)
    {
        $task = TodoTask::findOrFail($id);

        $this->authorize('delete', $task);

        $task->delete();

        $taskShares = $task->shares->pluck('id');
        $taskShares[] = $task->creator->id;
        $this->notifyTaskUsers($task, $taskShares, TaskNotification::TYPE_DELETED);

        return $this->redirectWithQuerySuccess('todo.task.list', 'Task deleted successfully');
    }
}
