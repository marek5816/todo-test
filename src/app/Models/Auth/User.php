<?php

namespace App\Models\Auth;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Todo\TodoTask;
use App\Models\Todo\TodoShare;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function todoTasks()
    {
        return $this->hasMany(TodoTask::class, 'created_by');
    }

    public function sharedTasks()
    {
        return $this->hasMany(TodoShare::class, 'users_id');
    }

    public function completedtasks()
    {
        return $this->hasMany(TodoTask::class, 'completed_by');
    }

    public function todoSharedTasks()
    {
        return $this->belongsToMany(TodoTask::class, 'todo_shares', 'user_id', 'todo_task_id');
    }
}
