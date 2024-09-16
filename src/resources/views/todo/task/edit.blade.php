@extends('base')

@section('content')
    <div class="container mt-5">
        @include('components.todo.task.form-card', [
            'title' => 'Edit Task',
            'actionUrl' => route('todo.task.update', $task->id),
            'buttonText' => 'Update Task'
        ])
        <button onclick="history.back()" class="btn btn-secondary">Go Back</button>
    </div>
@endsection
