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
        Schema::create('child_data', function (Blueprint $table) {
            $table->foreignId('survey_id')->constrained('survey');
            $table->string('name');
            $table->date('birthdate');
            $table->string('employement_status');
            $table->string('received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_data');
    }
};
