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
        Schema::table('shifts', function (Blueprint $table) {
            $table->dateTime('start_datetime')->nullable()->after('location');
            $table->dateTime('end_datetime')->nullable()->after('start_datetime');
            $table->string('time')->nullable()->change(); // Make old time field nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn(['start_datetime', 'end_datetime']);
            $table->string('time')->nullable(false)->change();
        });
    }
};
