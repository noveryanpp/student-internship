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
        DB::unprepared('
            CREATE FUNCTION getInternshipPeriod(start_date DATE, end_date DATE)
            RETURNS INT
            DETERMINISTIC
            RETURN DATEDIFF(end_date, start_date);
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('
            DROP FUNCTION IF EXISTS getInternshipPeriod;
        ');
    }
};
