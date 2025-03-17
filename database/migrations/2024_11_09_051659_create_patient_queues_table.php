<?php

use App\Models\Doctor;
use App\Models\Opd;
use App\Models\Patient;
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
        Schema::create('patient_queues', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->nullable();
            $table->string('queue_id')->unique()->nullable();

            $table->string('medical_record_id')->nullable(); // Foreign key for the medical_record (medical_record_id)

            $table->string('patient_id')->nullable(); // Foreign key for the patient (user_id)

            $table->string('opd_id')->nullable(); // Foreign key for the opd (user_id)

            $table->string('doctor_id')->nullable(); // Foreign key for the doctor (user_id)

            // Define queue_status as an ENUM field
            $table->enum('queue_status', [
                'Awaiting Doctor Selection',
                'Awaiting Assessment',
                'Assessing',
                'Awaiting Consultation',
                'Consulting',
                'Completed',
                'Cancelled'
            ])->default('Awaiting Doctor Selection');

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

            $table->timestamp('queued_at')->nullable();
            $table->timestamp('doctor_selected_at')->nullable();
            $table->timestamp('assessment_started_at')->nullable();
            $table->timestamp('assessment_done_at')->nullable();
            $table->timestamp('consultation_started_at')->nullable();
            $table->timestamp('consultation_done_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_queues');
    }
};
