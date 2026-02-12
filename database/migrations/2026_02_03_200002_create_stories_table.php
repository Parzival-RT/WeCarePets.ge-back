<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // {"ka": "...", "en": "..."} - translatable
            $table->string('cover_image'); // path to image
            $table->string('video_url'); // social media embed URL
            $table->json('description')->nullable(); // {"ka": "...", "en": "..."} - translatable
            $table->enum('category', ['helped', 'healed'])->default('helped');
            $table->decimal('amount_spent', 10, 2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
