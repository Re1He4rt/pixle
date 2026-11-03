<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController; // Tambahkan ini

// Ubah rute utama (/) agar memanggil SearchController
Route::get('/', [SearchController::class, 'index']);

// Jika kamu belum memindahkan rute api ke routes/api.php,
// sementara bisa taruh di sini dulu untuk testing:
Route::get('/api/search', [SearchController::class, 'search']);
