<?php

namespace App\Http\Controllers\Todo\Category;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoCategory;
use App\Models\Todo\TodoTask;
use App\Traits\Route;
use Illuminate\Http\Request;

class EditController extends Controller
{
    use Route;

    public function view($id)
    {
        $category = TodoCategory::findOrFail($id);

        return view('todo.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = TodoCategory::findOrFail($id);
        $category->name = $request->name;

        $category->save();

        return $this->redirectWithQuerySuccess('todo.category.list', 'Category updated successfully');
    }
}
