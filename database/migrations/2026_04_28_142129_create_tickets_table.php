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
        Schema::create('tickets', function (Blueprint $table) {
           $table->id();
    $table->string('ticket_number')->unique();
    $table->foreignId('user_id')->constrained();
    $table->foreignId('campus_id')->constrained();
    $table->foreignId('category_id')->constrained();
    $table->string('subject');
    $table->text('description');
    $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
    $table->enum('status', ['pending', 'in_progress', 'resolved', 'closed'])->default('pending');
    $table->foreignId('assigned_to')->nullable()->constrained('users');
    $table->text('resolution')->nullable();
    $table->timestamp('resolved_at')->nullable();
    $table->timestamps();
    $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
