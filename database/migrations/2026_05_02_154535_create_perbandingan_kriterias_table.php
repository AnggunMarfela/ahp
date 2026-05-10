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
        Schema::create('perbandingan_kriteria', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kriteria_1')->constrained('kriteria')->cascadeOnDelete();
    $table->foreignId('kriteria_2')->constrained('kriteria')->cascadeOnDelete();
    $table->double('nilai'); // skala Saaty 1–9
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbandingan_kriterias');
    }
};
