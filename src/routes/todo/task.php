<?php

use Illuminate\Support\Facades\Route;

Route::get('/todo/tasks', [\App\Http\Controllers\Todo\Task\ListController::class, 'view'])->name('todo.task.list');

Route::post('/todo/task-create', [\App\Http\Controllers\Todo\Task\CreateController::class, 'create'])->name('todo.task.create');

Route::get('/todo/task-edit/{id}', [\App\Http\Controllers\Todo\Task\EditController::class, 'view'])->name('todo.task.edit');
Route::patch('/todo/task-edit/{id}', [\App\Http\Controllers\Todo\Task\EditController::class, 'update'])->name('todo.task.update');

Route::delete('/todo/task-delete/{id}', [\App\Http\Controllers\Todo\Task\DeleteController::class, 'delete'])->name('todo.task.delete');
Route::patch('/todo/task-restore/{id}', [\App\Http\Controllers\Todo\Task\RestoreController::class, 'restore'])->name('todo.task.restore');

Route::patch('/todo/task-done/{id}', [\App\Http\Controllers\Todo\Task\DoneController::class, 'done'])->name('todo.task.done');
Route::patch('/todo/task-incomplete/{id}', [\App\Http\Controllers\Todo\Task\IncompleteController::class, 'incomplete'])->name('todo.task.incomplete');
