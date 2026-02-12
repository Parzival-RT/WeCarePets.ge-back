<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // {"ka": "...", "en": "..."} - translatable
            $table->string('contact_person');
            $table->string('phone', 20);
            $table->enum('package', ['supporter', 'friend', 'partner', 'cofounder']);
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
            $table->enum('group', ['founders_club', 'heroes_companies'])->nullable()->default(null);
            $table->boolean('detail_page_enabled')->default(false);
            $table->json('description')->nullable(); // {"ka": "...", "en": "..."} - translatable
            $table->string('logo')->nullable(); // path to image
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
