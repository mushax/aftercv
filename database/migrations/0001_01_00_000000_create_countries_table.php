<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // {"en": "Syria", "ar": "سوريا"}
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