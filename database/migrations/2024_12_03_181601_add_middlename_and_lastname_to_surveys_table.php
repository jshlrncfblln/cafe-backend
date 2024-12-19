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
        Schema::table('surveys', function (Blueprint $table) {
            //
            $table->string('fathers_middlename')->after('fathers_firstname')->nullable();
            $table->string('fathers_lastname')->after('fathers_middlename')->nullable();
            $table->string('mothers_middlename')->after('mothers_firstname')->nullable();
            $table->string('mothers_lastname')->after('mothers_middlename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            //
            $table->string('fathers_middlename')->after('fathers_firstname')->nullable();
            $table->string('fathers_lastname')->after('fathers_middlename')->nullable();
            $table->string('mothers_middlename')->after('mothers_firstname')->nullable();
            $table->string('mothers_lastname')->after('mothers_middlename')->nullable();
        });
    }
};
