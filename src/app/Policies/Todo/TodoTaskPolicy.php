<?php

namespace App\Policies\Todo;

use App\Models\Auth\User;
use App\Models\Todo\TodoTask;

class TodoTaskPolicy
{
    public function update(User $user, TodoTask $task)
    {
        return $task->isSharedWithCurrentUser() || $task->isCreatedByCurrentUser();
    }

    public function delete(User $user, TodoTask $task)
    {
        return $task->isCreatedByCurrentUser();
    }

    public function restore(User $user, TodoTask $task)
    {
        return $this->delete($user, $task);
    }
}
