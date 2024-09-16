@extends('base')

@section('content')
    <div class="container mt-5">
        @include('components.todo.category.form-card', [
            'title' => "Edit Category",
            'category' => $category,
            'actionUrl' => route('todo.category.update', $category->id),
            'buttonText' => 'Update Category'
        ])
        <button onclick="history.back()" class="btn btn-secondary">Go Back</button>
    </div>
@endsection
