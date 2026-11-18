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
        Schema::create('certificates', function (Blueprint $table) {
    $table->id();
    $table->string('title'); // Nama Sertifikat / Prestasi
    $table->string('issuer'); // Penerbit / Penyelenggara
    $table->string('image')->nullable(); // Dokumentasi Sertifikat
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
