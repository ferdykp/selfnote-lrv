<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('note_contents', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_favorite')->default(false);
            $table->string('tags', 500)->nullable();
        });
        Schema::create('note_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_content_id')->constrained('note_contents')->cascadeOnDelete();
            $table->string('title');
            $table->longText('content');
            $table->string('status', 20);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('note_revisions'); Schema::table('note_contents', fn (Blueprint $table) => $table->dropColumn(['is_pinned','is_favorite','tags'])); }
};
