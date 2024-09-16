<?php


namespace App\Http\Controllers\Todo\Category;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use App\Traits\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    use Route;

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        TodoCategory::create([
            'name' => $request->name
        ]);

        return $this->redirectWithQuerySuccess('todo.category.list', 'Category created successfully!');
    }
}
