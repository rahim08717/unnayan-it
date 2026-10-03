<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_entry_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_entry_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->enum('file_type', ['image', 'video', 'document'])->default('image');
            $table->enum('attachment_type', ['before', 'after', 'during', 'problem', 'general'])->default('general');
            $table->string('mime_type')->nullable();
            $table->integer('file_size')->default(0); // In KB
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_entry_attachments');
    }
};