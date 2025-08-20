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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('medium')->nullable(); // Техника (масло, акрил и т.д.)
            $table->string('dimensions')->nullable(); // Размеры
            $table->year('year_created')->nullable(); // Год создания
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_sold')->default(false);
            $table->boolean('is_available_for_print')->default(false);
            $table->json('tags')->nullable(); // Теги как JSON
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
