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
        Schema::create('note_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('images')->nullable();
            $table->date('date')->nullable();
            $table->softDeletes(); // ← kolom 'deleted_at' untuk fitur soft delete
            $table->timestamps();  // simpan created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_contents');
    }
};
