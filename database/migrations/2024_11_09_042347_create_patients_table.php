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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('birthdate');
            $table->string('sex');
            $table->string('religion');
            $table->string('civil_status');
            $table->string('citizenship');
            $table->string('healthcard_number')->nullable();

            $table->string('address');
            $table->string('email')->unique();
            $table->string('contact_number');

            $table->string('emergency_contact1_name');
            $table->string('emergency_contact1_number');
            $table->string('emergency_contact1_relationship');
            $table->string('emergency_contact2_name');
            $table->string('emergency_contact2_number');
            $table->string('emergency_contact2_relationship');

            $table->string('account_status');
            $table->string('queue_status');

            $table->string('pre_registration_code');
            $table->timestamp('pre_registered_at')->nullable();
            $table->timestamp('registered_at')->nullable();


            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
