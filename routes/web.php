<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

// Mengarahkan halaman utama ke method index di ProjectController
Route::get('/', [ProjectController::class, 'index']);

// Route untuk menyimpan proyek dari Admin
Route::post('/admin/project/store', [ProjectController::class, 'store'])->name('project.store');
Route::get('/', function () {
    return view('frontend.index');
});
