<?php

use App\Http\Controllers\PortfolioController as P;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/', [P::class, 'index']);

Route::post('/messages', [P::class, 'storeMessage'])->middleware('throttle:10,1');
Route::post('/admin/login', [P::class, 'login'])->middleware('throttle:10,1');
Route::post('/admin/logout', [P::class, 'logout']);

Route::middleware(AdminOnly::class)->prefix('admin')->group(function () {
    Route::get('/messages', [P::class, 'messages']);
    Route::post('/projects', [P::class, 'storeProject']);
    Route::put('/projects/{project}', [P::class, 'updateProject']);
    Route::delete('/projects/{project}', [P::class, 'destroyProject']);
    Route::post('/certificates', [P::class, 'storeCertificate']);
    Route::delete('/certificates/{certificate}', [P::class, 'destroyCertificate']);
    Route::put('/profile', [P::class, 'updateProfile']);
});
