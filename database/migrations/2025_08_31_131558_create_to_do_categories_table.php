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
        Schema::create('to_dos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('due_date')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('to_do_category_id')->references('id')->on('to_do_categories');
            $table->foreignId('to_do_status_id')->references('id')->on('to_do_statuses');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->string('title');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_dos');
    }
};
