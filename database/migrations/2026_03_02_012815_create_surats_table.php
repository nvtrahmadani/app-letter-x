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
    Schema::create('surat', function (Blueprint $table) { // Saya buat 'surat' (tunggal) sesuai keinginan Anda
        $table->id();
        $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
        $table->foreignId('poli_id')->constrained()->cascadeOnDelete();
        $table->string('patient_name');
        $table->string('nomor_surat')->unique()->nullable(); // WAJIB ADA untuk menyimpan nomor SK-2026-00001
        $table->date('start_date');
        $table->date('end_date');
        $table->text('diagnosis')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
