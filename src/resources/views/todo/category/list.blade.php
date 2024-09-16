@extends('base')

@section('content')
    <div class="container mt-5">
        @include('components.todo.session-alert')

        <!-- Task Form -->
        @include('components.todo.category.form-card', [
            'title' => "Create New Category",
            'actionUrl' => route('todo.category.create'),
            'buttonText' => 'Add Category'
        ])

        <!-- Filter -->
        @include('components.todo.filter-card', [
            'title' => 'Filters',
            'actionUrl' => route('todo.category.list'),
            'isTask' => false
        ])

        <!-- List -->
        @include('components.todo.list-card', [
            'title' => 'Categories List',
            'items' => $categories,
            'isTask' => false
        ])

        <!-- Pagination -->
        @include('components.todo.pagination', ['collection' => $categories])
    </div>
@endsection
