<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pelamar\PelamarController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pelamar\BiodataController;
use App\Http\Controllers\Pelamar\LamaranController;
use Illuminate\Support\Facades\Storage;
use App\Models\Lamaran;
use App\Http\Middleware\CheckLamaranStatus;
use App\Http\Controllers\Admin\AdminAlumniController;
use App\Http\Controllers\PengaturanController;
use App\Models\Pengaturan;

// Route::get('/', function () {
//     return view('welcome');
// });

// Register route
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Default Auth routes (Login, Register, etc.)
Auth::routes();

// Home route after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pelamar', [AdminController::class, 'pelamar'])->name('pelamar');
    Route::get('/detail-pelamar/{id}', [AdminController::class, 'detailPelamar'])->name('detail.pelamar');
    Route::post('/pelamar/update-status/{id}', [AdminController::class, 'updateStatus'])->name('pelamar.update-status');
    Route::get('/pelamar/download/{id}/{type}', [AdminController::class, 'download'])->name('pelamar.download');
    Route::get('/alumni', [AdminController::class, 'alumni'])->name('alumni');
    Route::get('/alumni/{id}', [AdminController::class, 'detailAlumni'])->name('detailalumni');
    Route::get('/alumni/export', [AdminController::class, 'exportAlumni'])->name('alumni.export');
    Route::get('/alumni/download-sertifikat/{id}', [AdminController::class, 'downloadSertifikat'])
        ->name('alumni.download-sertifikat');
   Route::get('/admin/alumni/download-sertifikat/{id}', [AdminController::class, 'downloadSertifikat'])
    ->name('admin.alumni.download-sertifikat');
   Route::delete('/alumni/{id}', [AdminController::class, 'destroy'])
    ->name('alumni.destroy');

   Route::post('/lamaran/{id}/set-posisi', [AdminController::class, 'setPosisi'])
    ->name('setPosisi');
    Route::get('/posisi', [AdminController::class, 'posisi'])->name('posisi');
Route::post('/posisi', [AdminController::class, 'storePosisi'])->name('posisi.store');

// ===== POSISI CRUD =====
Route::get('/posisi', [AdminController::class, 'posisi'])->name('posisi');
Route::get('/posisi/create', [AdminController::class, 'createPosisi'])->name('posisi.create');
Route::post('/posisi/store', [AdminController::class, 'storePosisi'])->name('posisi.store');

Route::get('/posisi/edit/{id}', [AdminController::class, 'editPosisi'])->name('posisi.edit');
Route::put('/posisi/update/{id}', [AdminController::class, 'updatePosisi'])->name('posisi.update');
Route::delete('/posisi/delete/{id}', [AdminController::class, 'destroyPosisi'])->name('posisi.delete');




});


Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/pengaturan', [PengaturanController::class, 'index'])
        ->name('pengaturan.index');

    Route::match(['post','put'], '/pengaturan/update', [PengaturanController::class, 'update'])
    ->name('pengaturan.update');

});

Route::get('/', function () {

    $alumni = app(AdminController::class)->getAlumniForLandingPage();

    $pengaturan = Pengaturan::first();

    return view('welcome', compact('alumni', 'pengaturan'));
});

Route::prefix('pelamar')->middleware('auth')->group(function () {
    Route::get('/biodata', [PelamarController::class, 'biodata'])->name('pelamar.biodata');
    
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('pelamar')->name('pelamar.')->group(function () {
        Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata');
        Route::get('/biodata/edit', [BiodataController::class, 'edit'])->name('edit-biodata');
        Route::put('/biodata/update', [BiodataController::class, 'update'])->name('update-biodata');
        
        Route::get('/status', [LamaranController::class, 'status'])->name('status');
        Route::get('/rekap', [LamaranController::class, 'rekap'])->name('rekap');
        Route::get('/detail/{id}', [LamaranController::class, 'detail'])->name('detail');
        Route::get('/download-surat/{id}/{type}', [LamaranController::class, 'downloadSurat'])
            ->name('download-surat');
            
        
        // Route untuk formulir dengan middleware pengecekan status
        Route::controller(LamaranController::class)->middleware(CheckLamaranStatus::class)->group(function () {
            Route::get('/formulir', 'create')->name('formulir');
            Route::post('/formulir', 'store')->name('formulir.store');
        });
        Route::delete('/lamaran/{id}', [LamaranController::class, 'destroy'])
    ->name('delete');

    });
});


Route::get('/', function () {
    $alumni = app(AdminController::class)->getAlumniForLandingPage();
    return view('welcome', compact('alumni')); // Changed 'index' to 'welcome'
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

