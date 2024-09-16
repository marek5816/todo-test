<?php


namespace App\Models\Todo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function todoTasks()
    {
        return $this->belongsToMany(TodoTask::class, 'todo_task_category', 'category_id', 'todo_task_id');
    }
}
