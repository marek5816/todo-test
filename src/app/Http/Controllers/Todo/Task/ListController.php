<?php

namespace App\Http\Controllers\Todo\Task;


use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function view(Request $request)
    {
        $tasks = TodoTask::with('categories');

        if ($request->filled('completed')) {
            $tasks->where('completed_by', $request->completed == 1 ? '!=' : '=', null);
        }

        if ($request->filled('category')) {
            $tasks = $tasks->whereHas('categories', function ($query) use ($request) {
                $query->where('category_id', $request->category);
            });
        }

        if ($request->filled('shared')) {
            if ($request->shared == 1) {
                $tasks->whereHas('shares', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            } else {
                $tasks->where('created_by', Auth::id());
            }
        } else {
            $tasks = $tasks->where(function ($query) {
                $query->where('created_by', Auth::id())
                    ->orWhereHas('shares', function ($query) {
                        $query->where('user_id', Auth::id());
                    });
            });
        }

        if ($request->filled('deleted') && $request->deleted == 1) {
            $tasks = $tasks->onlyTrashed();
        }

        $tasks = $tasks->paginate(10);

        $categories = TodoCategory::all();
        $users = User::where('id', '!=', auth()->id())->get();

        return view('todo.task.list', compact('tasks', 'categories', 'users'))->render();
    }
}
