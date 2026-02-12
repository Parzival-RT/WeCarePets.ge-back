<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('story_heroes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('heroable_id');
            $table->string('heroable_type'); // "App\Models\Company" ან "App\Models\Person"
            $table->timestamps();

            // Index for polymorphic relationship
            $table->index(['heroable_type', 'heroable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('story_heroes');
    }
};
