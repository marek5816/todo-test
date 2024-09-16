<?php

namespace App\Models\Todo;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'completed_at',
        'created_by',
        'completed_by'
    ];

    protected $dates = ['completed_at', 'deleted_at'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function categories()
    {
        return $this->belongsToMany(TodoCategory::class, 'todo_task_category', 'todo_task_id', 'category_id');
    }

    public function shares()
    {
        return $this->belongsToMany(User::class, 'todo_shares', 'todo_task_id', 'user_id');
    }

    public function isSharedWithCurrentUser() {
        return $this->shares->pluck('pivot.user_id')->contains(auth()->id());
    }

    public function isCreatedByCurrentUser() {
        return $this->created_by === auth()->id();
    }

}
