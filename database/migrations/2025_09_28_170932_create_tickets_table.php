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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('match_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('seat_id')->constrained()->onDelete('cascade');
            $table->string('qr_code_path')->nullable();
            $table->string('status')->default('reserved'); // reserved, paid, used, cancelled
            $table->timestamp('reservation_expires_at')->nullable(); // +15 мин от создания
            $table->timestamps();

            // 🔒 Уникальность: одно место = один билет на матч
            $table->unique(['seat_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
