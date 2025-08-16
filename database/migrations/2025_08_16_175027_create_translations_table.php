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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('group')->index(); // مجموعة الترجمة (مثال: cv_sections)
            $table->string('key');            // مفتاح الترجمة (مثال: personal_info)
            $table->text('text');             // النص المترجم
            $table->string('locale')->index(); // رمز اللغة (ar, en)

            // لمنع تكرار نفس المفتاح بنفس اللغة ونفس المجموعة
            $table->unique(['group', 'key', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};