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
        Schema::create('survey_church_programs', function (Blueprint $table) {
            $table->foreignId('survey_id')->constrained('surveys');
            $table->foreignId('church_program_id')->constrained('church_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_church_programs');
    }
};
