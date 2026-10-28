<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FilmRequestController;
use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AdminFilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Middleware\IsAdmin; 
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN (GUEST & USER)
Route::get('/', [FilmController::class, 'welcome'])->name('welcome');

// 2. AUTHENTICATION (Login/Register/Logout)
Auth::routes();

// 3. GROUP USER LOGIN (Harus Login Dulu)
Route::middleware(['auth'])->group(function () {

    // Redirect /home ke Welcome agar tampilan konsisten
    Route::get('/home', function() {
        return redirect()->route('welcome');
    })->name('home');
    
    // --- FITUR REVIEW ---
    Route::post('/film/{slug}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{id}/like', [ReviewController::class, 'toggleLike'])->name('reviews.like');

    // --- FITUR REQUEST FILM ---
    Route::get('/request-film', [FilmRequestController::class, 'index'])->name('requests.index');
    Route::post('/request-film', [FilmRequestController::class, 'store'])->name('requests.store');

    // --- FITUR WATCHLIST (URL: /watchlists, Code: playlist) ---
    // Kita ubah tampilan URL jadi 'watchlists' tapi nama route tetap 'playlists.x'
    Route::resource('watchlists', PlaylistController::class)
         ->parameters(['watchlists' => 'playlist']) 
         ->names('playlists'); 

    // Toggle Simpan/Hapus (AJAX)
    Route::post('/watchlists/toggle/{film_id}', [PlaylistController::class, 'toggleFilm'])->name('playlists.toggle');
    
    // Hapus Film Spesifik dari Halaman Detail Watchlist
    Route::delete('/watchlists/{playlist_id}/remove/{film_id}', [PlaylistController::class, 'removeFilm'])->name('playlists.remove');

    // --- FITUR UBAH PASSWORD ---
    Route::get('/password/change', [ProfileController::class, 'editPassword'])->name('password.change');
    Route::put('/password/change', [ProfileController::class, 'updatePassword'])->name('password.change.update');

});

// 4. GROUP ADMIN (Hanya Admin)
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {

    // EXPORT PDF
    Route::get('/films/export-pdf', [AdminFilmController::class, 'exportPdf'])->name('admin.films.export');

    // EXPORT EXCEL
    Route::get('/films/export-excel', [AdminFilmController::class, 'exportExcel'])->name('admin.films.export_excel');

    // Dashboard Request
    Route::get('/requests', [AdminRequestController::class, 'index'])->name('admin.requests');
    Route::patch('/requests/{id}/approve', [AdminRequestController::class, 'approve'])->name('admin.requests.approve');
    Route::patch('/requests/{id}/reject', [AdminRequestController::class, 'reject'])->name('admin.requests.reject');

    // Manajemen Film (CRUD)
    Route::get('/films', [AdminFilmController::class, 'index'])->name('admin.films.index');
    Route::get('/films/create', [AdminFilmController::class, 'create'])->name('admin.films.create');
    Route::post('/films', [AdminFilmController::class, 'store'])->name('admin.films.store');
    Route::get('/films/{id}/edit', [AdminFilmController::class, 'edit'])->name('admin.films.edit');
    Route::put('/films/{id}', [AdminFilmController::class, 'update'])->name('admin.films.update');
    Route::delete('/films/{id}', [AdminFilmController::class, 'destroy'])->name('admin.films.delete');

    // Manajemen User
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.delete');
});

// 5. PUBLIC ROUTES (Bisa Diakses Tanpa Login)
// Note: Route dengan parameter {slug} sebaiknya ditaruh paling bawah
Route::get('/search', [FilmController::class, 'search'])->name('search');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/film/{slug}', [FilmController::class, 'show'])->name('films.show');