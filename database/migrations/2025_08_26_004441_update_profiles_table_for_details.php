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
    Schema::table('profiles', function (Blueprint $table) {
        // Storing complex data as JSON for flexibility
        $table->json('passports')->nullable()->after('emails'); // For multiple nationalities/passports
        $table->json('addresses')->nullable()->after('passports'); // For permanent and current addresses
        $table->json('driving_license')->nullable()->after('addresses'); // For driving license details
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
