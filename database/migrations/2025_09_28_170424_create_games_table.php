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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('home_team_name');
            $table->string('away_team_name');
            $table->string('home_team_logo_path')->nullable();
            $table->string('away_team_logo_path')->nullable();
            $table->dateTime('start_at');
            $table->integer('duration_minutes')->default(105);
            $table->string('status')->default('draft'); // draft, ready, tickets_open, completed, cancelled
            $table->foreignId('stadium_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
