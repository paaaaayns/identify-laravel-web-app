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
            $table->string('queue_id')->unique()->nullable();
            $table->foreignIdFor(Patient::class);
            $table->foreignIdFor(Opd::class);
            $table->foreignIdFor(Doctor::class);
            // Define queue_status as an ENUM field
            $table->enum('queue_status', [
                'Waiting',
                'Vitals Taken',
                'Consulting',
                'Completed',
                'Cancelled'
            ])->default('Waiting');

            $table->string('blood_pressure')->nullable();
            $table->string('temperature')->nullable();
            $table->string('pulse_rate')->nullable();
            $table->string('respiration_rate')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('o2')->nullable();
            $table->text('other')->nullable();

            $table->string('mr1')->nullable();
            $table->string('mr2')->nullable();
            $table->string('mr3')->nullable();
            $table->string('mr4')->nullable();
            $table->string('mr5')->nullable();
            $table->string('mr6')->nullable();
            $table->string('mr7')->nullable();
            $table->string('mr8')->nullable();

            $table->timestamp('queued_at')->nullable();
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
