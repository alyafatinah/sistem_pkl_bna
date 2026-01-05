<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    JadwalController,
    SiswaController,
    UserController,
    GuruPembimbingController,
    MitraController,
    NilaiController,
    KaprodiController,
    JurnalController,
    SiswaLookupController,
    HumasController
};
use App\Models\Siswa;

/*
|--------------------------------------------------------------------------
| ROUTE UMUM
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->middleware('role:3')->name('dashboard.guru');
    Route::get('/dashboard/kaprodi', [DashboardController::class, 'kaprodi'])->middleware('role:1')->name('dashboard.kaprodi');
    Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])->middleware('role:4')->name('dashboard.siswa');
});

/*
|--------------------------------------------------------------------------
| DATA MASTER (ADMIN / HUMAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1, 3,2,5'])->group(function () {
    Route::resource('siswa', SiswaController::class);
    Route::resource('guruPembimbing', GuruPembimbingController::class);
    Route::resource('mitra', MitraController::class);
    Route::resource('kaprod', KaprodiController::class);
    Route::resource('user', UserController::class);
});

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get(
        '/siswa/jurusan/{jurusan_id}',
        [SiswaController::class, 'siswaPerJurusan']
    )->name('siswa.per_jurusan');
});
//|--------------------------------------------------------------------------
Route::get(
    '/guru-pembimbing/per-jurusan/{jurusan_id}',
    [GuruPembimbingController::class, 'guruPerJurusan']
)->name('gurupembimbing.per_jurusan');

// Route::get('/siswa/per-jurusan/{jurusan}',
//     [SiswaController::class, 'perJurusan']
// )->middleware('role:1,3')
//  ->name('siswa.per_jurusan');



/*
|--------------------------------------------------------------------------
| JADWAL PKL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    Route::middleware('role:2,5')->group(function () {
        Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| NILAI PKL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // umum
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');

    // lookup siswa (AJAX – tetap web.php)
    Route::get('/siswa-by-nis-nilai/{nis}', [SiswaLookupController::class, 'byNisNilai'])
        ->name('siswa.byNisNilai');

    // guru & admin
    Route::middleware('role:3,5')->group(function () {
        Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/nilai/{nilai}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{nilai}', [NilaiController::class, 'update'])->name('nilai.update');
        Route::delete('/nilai/{nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    });

    // kaprodi
    Route::get('/nilai/jurusan/{id}', [NilaiController::class, 'nilaiPerJurusan'])
        ->middleware('role:1,3')
        ->name('nilai.per_jurusan');

    // siswa
    Route::get('/nilai/siswa/{id}', [NilaiController::class, 'nilaiPerSiswa'])
        ->middleware('role:4')
        ->name('nilai.per_siswa');
});


Route::get('/nilai/nis-by-jurusan', [NilaiController::class, 'nisByJurusan'])
    ->middleware('auth');

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::post('/nilai/{nilai}/validasi', [NilaiController::class, 'validasi'])
        ->name('nilai.validasi');
});

Route::middleware(['auth', 'role:1,3,5'])->group(function () {
    Route::get(
        '/nilai/jurusan/{jurusan_id}/pdf',
        [\App\Http\Controllers\NilaiController::class, 'exportPdfPerJurusan']
    )->name('nilai.export_jurusan');
});


/*
|--------------------------------------------------------------------------
| JURNAL PKL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |------------------------------------------------------------------
    | ROUTE GLOBAL (DIPAKAI DASHBOARD)
    |------------------------------------------------------------------
    */
    Route::get('/jurnal/siswa/{id}', [JurnalController::class, 'jurnalPerSiswa'])
        ->middleware('role:4')
        ->name('jurnal.per_siswa');

    /*
    |------------------------------------------------------------------
    | JURNAL SISWA
    |------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:4'])->group(function () {

        Route::get(
            '/jurnal/saya/create',
            [JurnalController::class, 'createPerSiswa']
        )->name('jurnal.create_per_siswa');

        Route::post(
            '/jurnal/saya',
            [JurnalController::class, 'storePerSiswa']
        )->name('jurnal.store_per_siswa');
    });


    /*
    |------------------------------------------------------------------
    | JURNAL GURU / ADMIN
    |------------------------------------------------------------------
    */
    Route::middleware('role:3,4,5')->group(function () {
        Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
        Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
        Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::get('/jurnal/{id}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
        Route::put('/jurnal/{id}', [JurnalController::class, 'update'])->name('jurnal.update');
        Route::delete('/jurnal/{id}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');
        Route::put('/jurnal/{id}/status', [JurnalController::class, 'updateStatus'])->name('jurnal.updateStatus');
        Route::put('/jurnal/{id}/setujui', [JurnalController::class, 'setujui'])->name('jurnal.setujui');
    });

    // kaprodi
    Route::get('/jurnal/jurusan/{id}', [JurnalController::class, 'jurnalPerJurusan'])
        ->middleware('role:1,3')
        ->name('jurnal.per_jurusan');
});


/*
|--------------------------------------------------------------------------
| EXPORT PDF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/nilai/export/pdf', [NilaiController::class, 'exportPdf'])
        ->name('nilai.export.pdf');
});



Route::get('/users/export', [UserController::class, 'export'])
    ->middleware('auth')
    ->name('users.export');

Route::get('/users/export-pdf', [UserController::class, 'exportPdf'])
    ->middleware('auth')
    ->name('users.export.pdf');


/*
|--------------------------------------------------------------------------
| HUMAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ROUTE PENGARAH (SATU PINTU)
    Route::get('/humas', function () {
        $user = Auth::user();

        // ADMIN
        if ($user->role_id == 5) {
            return redirect()->route('humas.index');
        }

        // HUMAS
        if ($user->role_id == 2) {
            return redirect()->route('humas.index-humas');
        }

        abort(403);
    })->name('humas.home');

    // ADMIN: CRUD HUMAS
    Route::resource('humas', HumasController::class)
        ->except(['show', 'destroy']);

    // HUMAS: PROFIL
    Route::get('/humas/profil', [HumasController::class, 'indexHumas'])
        ->name('humas.index-humas');
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
