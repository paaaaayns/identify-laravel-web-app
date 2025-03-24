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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->nullable();
            $table->string('user_id')->unique()->nullable();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('birthdate');
            $table->string('sex');
            $table->string('religion')->nullable();
            $table->string('civil_status');
            $table->string('citizenship');

            $table->string('address');
            $table->string('email')->unique();
            $table->string('contact_number');
            $table->string('room');

            $table->string('type');
            $table->string('license_number')->unique();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
