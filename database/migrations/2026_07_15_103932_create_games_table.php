<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('title_fa');
            $table->string('title_en');
            $table->string('subtitle_fa')->nullable();
            $table->text('description_fa')->nullable();
            $table->unsignedSmallInteger('stage_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['city_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
