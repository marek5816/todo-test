<?php

use Illuminate\Support\Facades\Route;

Route::get('/todo/categories', [\App\Http\Controllers\Todo\Category\ListController::class, 'view'])->name('todo.category.list');

Route::post('/todo/category-create', [\App\Http\Controllers\Todo\Category\CreateController::class, 'create'])->name('todo.category.create');

Route::get('/todo/category-edit/{id}', [\App\Http\Controllers\Todo\Category\EditController::class, 'view'])->name('todo.category.edit');
Route::patch('/todo/category-edit/{id}', [\App\Http\Controllers\Todo\Category\EditController::class, 'update'])->name('todo.category.update');

Route::delete('/todo/category-delete/{id}', [\App\Http\Controllers\Todo\Category\DeleteController::class, 'delete'])->name('todo.category.delete');
Route::patch('/todo/category-restore/{id}', [\App\Http\Controllers\Todo\Category\RestoreController::class, 'restore'])->name('todo.category.restore');
