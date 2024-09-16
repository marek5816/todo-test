<?php


namespace App\Http\Controllers\Todo\Category;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestoreController extends Controller
{
    use Route;

    public function restore($id)
    {
        $task = TodoCategory::withTrashed()->findOrFail($id);
        $task->restore();

        return $this->redirectWithQuerySuccess('todo.category.list', 'Category restored successfully');
    }
}
