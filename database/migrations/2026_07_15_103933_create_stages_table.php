<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('order');
            $table->unsignedTinyInteger('act');
            $table->string('location_fa');
            $table->string('title_fa');
            $table->text('intro_text');
            $table->string('code');
            $table->json('code_alternatives')->nullable();
            $table->string('next_destination_fa')->nullable();
            $table->timestamps();

            $table->unique(['game_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
