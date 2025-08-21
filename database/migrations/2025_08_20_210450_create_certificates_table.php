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
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cv_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('issuing_organization');
        $table->string('issue_date', 7); // YYYY-MM format
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
