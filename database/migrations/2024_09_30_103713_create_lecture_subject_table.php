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
        Schema::create('lecture_subject', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('lecture_id')->constrained()->onDelete('cascade'); // Foreign key for class
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Foreign key for subject
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_subject');
    }
};
