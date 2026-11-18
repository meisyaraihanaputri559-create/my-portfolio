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
        Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('title'); // Judul Proyek
    $table->text('description'); // Deskripsi Proyek
    $table->string('technology'); // Teknologi yang digunakan
    $table->string('demo_link')->nullable(); // Link Demo
    $table->string('github_link')->nullable(); // Link GitHub
    $table->string('image')->nullable(); // Path Gambar / Screenshot
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
