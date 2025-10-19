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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sector_id')->constrained()->onDelete('cascade');
            $table->integer('row');
            $table->integer('number');
            $table->integer('x_coord')->nullable(); // для SVG клика
            $table->integer('y_coord')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['sector_id', 'row', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
