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
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stadium_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('color')->default('#cccccc');
            $table->decimal('price_per_seat', 8, 2);
            $table->string('seat_type')->default('regular'); // regular, vip, disabled
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
