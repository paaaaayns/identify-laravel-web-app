<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iris_biometrics', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->unique();

            $table->string('patient_ulid');

            $table->string('orientation');
            $table->binary('iris_code');
            $table->binary('mask_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iris_biometrics');
    }
};
