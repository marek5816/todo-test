<?php

namespace App\Traits\Notification;

use App\Models\Auth\User;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Auth;

trait NotifyTask
{
    public function notifyTaskUsers($task, $taskUsers, $notificationType)
    {
        if ($taskUsers == null) {
            return;
        }
        foreach ($taskUsers as $taskUser) {
            if ($taskUser === Auth::id()) {
                continue;
            }
            $taskUser = User::find($taskUser);
            if ($taskUser) {
                $taskUser->notify(new TaskNotification($task, $notificationType));
            }
        }
    }
}
