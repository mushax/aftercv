<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            // Add these two lines for emoji support
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->json('name');
            $table->string('iso_code', 2)->unique();
            $table->string('country_code', 5);
            $table->string('flag_emoji', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};