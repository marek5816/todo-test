@extends('base')

@section('content')
    <div class="container mt-5">
        @include('components.todo.session-alert')

        <!-- Task Form -->
        @include('components.todo.task.form-card', [
            'title' => 'Create New Task',
            'actionUrl' => route('todo.task.create'),
            'buttonText' => 'Add Task'
        ])

        <!-- Filter -->
        @include('components.todo.filter-card', [
            'title' => 'Filters',
            'actionUrl' => route('todo.task.list'),
            'isTask' => true
        ])

        <!-- List -->
        @include('components.todo.list-card', [
            'title' => 'Tasks List',
            'items' => $tasks,
            'isTask' => true
        ])

        <!-- Pagination -->
        @include('components.todo.pagination', ['collection' => $tasks])
    </div>
@endsection
