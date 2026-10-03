<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_report_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('asset_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('ticket_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('department')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('duration_minutes')->default(0);
            
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['draft', 'pending', 'in_progress', 'completed', 'cancelled'])->default('completed');
            
            $table->text('problem')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('solution')->nullable();
            $table->text('result')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['daily_report_id', 'branch_id', 'asset_id', 'ticket_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_entries');
    }
};