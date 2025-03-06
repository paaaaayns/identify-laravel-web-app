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
        Schema::create('iris_biometrics', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->unique();

            $table->string('patient_id');

            $table->string('orientation');
            $table->string('iris_code');
            $table->string('iris_mask_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iris_biometrics');
    }
};
