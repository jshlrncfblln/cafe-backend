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
        Schema::create('survey_livelihood', function (Blueprint $table) {
            $table->foreignId('survey_id')->constrained('survey');
            $table->foreignId('livelihood_id')->constrained('livelihood_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_livelihood');
    }
};
