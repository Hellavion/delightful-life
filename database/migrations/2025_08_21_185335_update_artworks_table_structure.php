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
        Schema::table('artworks', function (Blueprint $table) {
            // Переименование и добавление новых колонок
            $table->renameColumn('medium', 'technique');
            $table->renameColumn('year_created', 'year');
            
            // Добавление новых колонок
            $table->decimal('width', 8, 2)->nullable()->after('technique');
            $table->decimal('height', 8, 2)->nullable()->after('width');
            $table->boolean('is_available')->default(true)->after('is_featured');
            $table->string('image_path')->nullable()->after('slug');
            
            // Удаление неиспользуемых колонок
            $table->dropColumn(['dimensions', 'is_sold', 'is_available_for_print', 'tags', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            // Возврат обратно
            $table->renameColumn('technique', 'medium');
            $table->renameColumn('year', 'year_created');
            
            // Удаление добавленных колонок
            $table->dropColumn(['width', 'height', 'is_available', 'image_path']);
            
            // Возврат удаленных колонок
            $table->string('dimensions')->nullable();
            $table->boolean('is_sold')->default(false);
            $table->boolean('is_available_for_print')->default(false);
            $table->json('tags')->nullable();
            $table->integer('sort_order')->default(0);
        });
    }
};
