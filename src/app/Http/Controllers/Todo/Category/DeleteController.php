<?php


namespace App\Http\Controllers\Todo\Category;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    use Route;

    public function delete($id)
    {
        $task = TodoCategory::findOrFail($id);
        $task->delete();

        return $this->redirectWithQuerySuccess('todo.category.list', 'Category deleted successfully');
    }
}
