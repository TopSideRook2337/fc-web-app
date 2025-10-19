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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // гость может купить
            $table->decimal('total_amount', 10, 2);
            $table->string('currency')->default('RUB');
            $table->string('status')->default('cart'); // cart, pending, paid, cancelled, expired
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable(); // ID из Stripe/Tinkoff
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // для корзины
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
