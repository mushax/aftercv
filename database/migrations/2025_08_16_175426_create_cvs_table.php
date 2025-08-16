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
        Schema::create('cvs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title'); // عنوان السيرة الذاتية (مثال: سيرة ذاتية لوظائف التسويق)
        $table->string('template'); // اسم القالب المستخدم
        $table->string('locale', 2); // لغة السيرة الذاتية
        $table->string('public_url_hash')->nullable()->unique(); // رابط فريد لمشاركة السيرة الذاتية
        $table->boolean('is_public')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
