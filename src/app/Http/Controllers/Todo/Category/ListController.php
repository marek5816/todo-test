<?php

namespace App\Http\Controllers\Todo\Category;


use App\Http\Controllers\Controller;
use App\Models\Todo\TodoCategory;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function view(Request $request)
    {
        $categories = TodoCategory::query();

        if ($request->filled('deleted') && $request->deleted == 1) {
            $categories = $categories->onlyTrashed();
        }

        $categories = $categories->paginate(10);

        return view('todo.category.list', compact('categories'))->render();
    }
}
