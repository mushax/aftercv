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
    Schema::create('education', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cv_id')->constrained()->onDelete('cascade');
        $table->string('degree'); // e.g., Bachelor's in Computer Science
        $table->string('institution'); // e.g., Damascus University
        $table->string('city')->nullable();
        $table->string('start_date', 7); // CHANGED
        $table->string('end_date', 7)->nullable(); // CHANGED
        $table->text('description')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
