<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo_task_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('todo_task_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('todo_task_id')->references('id')->on('todo_tasks')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('todo_categories')->onDelete('cascade');

            $table->unique(['todo_task_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_task_category');
    }
};
