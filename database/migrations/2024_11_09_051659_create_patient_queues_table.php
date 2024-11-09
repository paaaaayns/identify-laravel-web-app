<?php

use App\Models\Doctor;
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
            $table->foreignIdFor(Patient::class);
            $table->foreignIdFor(Doctor::class);
            $table->string('queue_status');

            $table->string('blood_pressure');
            $table->string('temperature');
            $table->string('pulse_rate');
            $table->string('respiration_rate');
            $table->string('height');
            $table->string('weight');
            $table->string('o2');

            $table->string('mr1');
            $table->string('mr2');
            $table->string('mr3');
            $table->string('mr4');
            $table->string('mr5');
            $table->string('mr6');
            $table->string('mr7');
            $table->string('mr8');
            
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
