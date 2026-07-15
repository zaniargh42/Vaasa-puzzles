<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['name_fa', 'name_en', 'description_fa']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->json('name')->after('slug');
            $table->json('description')->nullable()->after('name');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['title_fa', 'title_en', 'subtitle_fa', 'description_fa']);
        });

        Schema::table('games', function (Blueprint $table) {
            $table->json('title')->after('slug');
            $table->json('subtitle')->nullable()->after('title');
            $table->json('description')->nullable()->after('subtitle');
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->dropColumn(['location_fa', 'title_fa', 'intro_text', 'next_destination_fa']);
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->json('location')->after('act');
            $table->json('title')->after('location');
            $table->json('intro_text')->after('title');
            $table->json('next_destination')->nullable()->after('code_alternatives');
        });
    }

    public function down(): void
    {
        Schema::table('stages', function (Blueprint $table) {
            $table->dropColumn(['location', 'title', 'intro_text', 'next_destination']);
        });

        Schema::table('stages', function (Blueprint $table) {
            $table->string('location_fa');
            $table->string('title_fa');
            $table->text('intro_text');
            $table->string('next_destination_fa')->nullable();
        });

        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'description']);
        });

        Schema::table('games', function (Blueprint $table) {
            $table->string('title_fa');
            $table->string('title_en');
            $table->string('subtitle_fa')->nullable();
            $table->text('description_fa')->nullable();
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn(['name', 'description']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->string('name_fa');
            $table->string('name_en');
            $table->text('description_fa')->nullable();
        });
    }
};
