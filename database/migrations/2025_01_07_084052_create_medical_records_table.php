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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->nullable();
            $table->string('medical_record_id')->unique()->nullable();

            $table->string('queue_id')->nullable(); // Foreign key for the queue (queue_id)
            $table->foreign('queue_id')->references('queue_id')->on('patient_queues');

            $table->string('patient_id')->nullable(); // Foreign key for the patient (user_id)
            $table->foreign('patient_id')->references('user_id')->on('patients');

            $table->string('opd_id')->nullable(); // Foreign key for the opd (user_id)
            $table->foreign('opd_id')->references('user_id')->on('opds');

            $table->string('doctor_id')->nullable(); // Foreign key for the doctor (user_id)
            $table->foreign('doctor_id')->references('user_id')->on('doctors');

            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('temperature')->nullable();
            $table->string('pulse_rate')->nullable();
            $table->string('respiration_rate')->nullable();
            $table->string('o2_sat')->nullable();
            $table->text('other')->nullable();

            $table->string('primary_complaint')->nullable();
            $table->string('duration_of_symptoms')->nullable();
            $table->string('intensity_and_frequency')->nullable();
            $table->string('findings')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('recommended_treatment')->nullable();
            $table->string('follow_up_instructions')->nullable();
            $table->string('referrals')->nullable();
            $table->string('doctor_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
