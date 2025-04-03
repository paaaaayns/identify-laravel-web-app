<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->nullable();
            $table->string('medical_record_id')->unique()->nullable();
            $table->string('queue_id')->nullable();
            $table->string('patient_id')->nullable();
            $table->string('opd_id')->nullable();
            $table->string('doctor_id')->nullable();

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

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
