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
        Schema::table('routine_work', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['enduser_id']);
            $table->dropForeign(['location_id']);

            // Baru drop column
            $table->dropColumn('owner_id');
            $table->dropColumn('enduser_id');
            $table->dropColumn('location_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('routine_work', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('enduser_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('enduser_id')->references('id')->on('endusers')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('location_lists')->onDelete('cascade');
        });
    }
};
