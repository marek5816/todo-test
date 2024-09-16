<?php

namespace App\Notifications;

use App\Models\Auth\User;
use App\Models\Todo\TodoTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskNotification extends Notification
{
    public $task;
    public $type;
    public $userId;

    public const TYPE_SHARED = 'shared';
    public const TYPE_UNSHARED = 'unshared';
    public const TYPE_UPDATED = 'updated';
    public const TYPE_DONE = 'done';
    public const TYPE_INCOMPLETE = 'incomplete';
    public const TYPE_DELETED = 'deleted';
    public const TYPE_RESTORED = 'restored';

    /**
     * Create a new notification instance.
     */
    public function __construct(TodoTask $task, $type)
    {
        $this->task = $task;
        $this->type = $type;
        $this->userId = Auth::id();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = $this->getMessage();

        return [
            'task_id' => $this->task->id,
            'message' => $message
        ];
    }

    protected function getMessage()
    {
        $user = User::find($this->userId);
        if ($user == null) {
            return "Notification related to task: {$this->task->title}";
        }

        return match ($this->type) {
            self::TYPE_SHARED => "User $user->name ($user->id) shared a task with you: {$this->task->name} ({$this->task->id})",
            self::TYPE_UNSHARED => "User $user->name ($user->id) removed sharing of task with you: {$this->task->name} ({$this->task->id})",
            self::TYPE_UPDATED => "User $user->name ($user->id) edited shared task: {$this->task->name} ({$this->task->id})",
            self::TYPE_DONE => "User $user->name ($user->id) marked done shared task: {$this->task->name} ({$this->task->id})",
            self::TYPE_INCOMPLETE => "User $user->name ($user->id) marked incomplete shared task: {$this->task->name} ({$this->task->id})",
            self::TYPE_DELETED => "User $user->name ($user->id) deleted shared task: {$this->task->name} ({$this->task->id})",
            self::TYPE_RESTORED => "User $user->name ($user->id) restored shared task: {$this->task->name} ({$this->task->id})",
            default => "Notification related to task: {$this->task->title}",
        };
    }
}
