<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->date('fathers_birthdate')->nullable();
            $table->date('mothers_birthdate')->nullable();
            $table->string('fathers_occupation')->nullable();
            $table->string('mothers_occupation')->nullable();
            $table->string('address')->nullable();
            $table->string('fathers_contact_number')->nullable();
            $table->string('mothers_contact_number')->nullable();
            $table->string('marriage_type');
            $table->string('years_married')->nullable();
            $table->string('family_income')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
