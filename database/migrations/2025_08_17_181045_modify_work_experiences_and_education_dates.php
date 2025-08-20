<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->string('start_date', 7)->change(); // YYYY-MM format
            $table->string('end_date', 7)->nullable()->change(); // YYYY-MM format
        });

        Schema::table('education', function (Blueprint $table) {
            $table->string('start_date', 7)->change(); // YYYY-MM format
            $table->string('end_date', 7)->nullable()->change(); // YYYY-MM format
        });
    }

    public function down(): void
    {
        // Reverting requires more complex logic, for simplicity we'll just change type back
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->date('start_date')->change();
            $table->date('end_date')->nullable()->change();
        });

        Schema::table('education', function (Blueprint $table) {
            $table->date('start_date')->change();
            $table->date('end_date')->nullable()->change();
        });
    }
};