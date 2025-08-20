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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            
            // Клиентская информация
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            
            // Детали заказа
            $table->text('description');
            $table->json('requirements')->nullable(); // Дополнительные требования
            $table->string('dimensions')->nullable(); // Размеры
            $table->date('deadline')->nullable(); // Желаемые сроки
            
            // Финансы
            $table->decimal('price', 10, 2);
            $table->decimal('deposit', 10, 2)->nullable(); // Предоплата
            $table->boolean('deposit_paid')->default(false);
            $table->boolean('full_payment_received')->default(false);
            
            // Статус
            $table->enum('status', [
                'pending',      // Ожидает подтверждения
                'confirmed',    // Подтвержден
                'in_progress',  // В работе
                'review',       // На согласовании
                'completed',    // Завершен
                'cancelled'     // Отменен
            ])->default('pending');
            
            $table->text('notes')->nullable(); // Заметки администратора
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
