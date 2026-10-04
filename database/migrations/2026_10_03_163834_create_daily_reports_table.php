<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->nullable()->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('report_date');
            $table->string('status')->default('submitted');
            $table->integer('total_entries')->default(0);
            $table->integer('total_duration_minutes')->default(0);
            $table->text('notes')->nullable();
            $table->text('summary_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['report_date', 'status', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};