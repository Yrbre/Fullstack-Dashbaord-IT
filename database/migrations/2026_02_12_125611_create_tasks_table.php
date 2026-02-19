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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('priority');
            $table->foreignId('category_id')->constrained('category_lists', 'id')->onDelete('cascade');
            $table->foreignId('assign_to')->constrained('users', 'id')->onDelete('cascade');
            $table->string('task_level');
            $table->foreignId('enduser_id')->constrained('endusers', 'id')->onDelete('cascade');
            $table->string('status');
            $table->string('progress');
            $table->string('delivered');
            $table->foreignId('location_id')->constrained('location_lists', 'id')->onDelete('cascade');
            $table->boolean('in_timeline')->default(true);
            $table->dateTime('schedule_start');
            $table->dateTime('schedule_end');
            $table->dateTime('actual_start')->nullable();
            $table->dateTime('actual_end')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
