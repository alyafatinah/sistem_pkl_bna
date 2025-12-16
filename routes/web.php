<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruPembimbingController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\JurnalController;
use App\Models\Siswa;
use App\Http\Controllers\SiswaLookupController;


/*
|--------------------------------------------------------------------------
| ROUTE UMUM
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/guru', [DashboardController::class, 'guru'])
    ->middleware(['auth', 'role:3'])
    ->name('dashboard.guru');

Route::get('/dashboard/kaprodi', [DashboardController::class, 'kaprodi'])
    ->middleware(['auth', 'role:1'])
    ->name('dashboard.kaprodi');

Route::get('/dashboard/siswa', [DashboardController::class, 'siswa'])
    ->middleware(['auth', 'role:4'])
    ->name('dashboard.siswa');

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
| DATA MASTER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1, 2,5'])->group(function () {
    Route::resource('siswa', SiswaController::class);
    Route::resource('guruPembimbing', GuruPembimbingController::class);
    Route::resource('mitra', MitraController::class);
    Route::resource('kaprod', KaprodiController::class);
    Route::resource('user', UserController::class);
});

Route::get('/siswa/jurusan/{id}', [SiswaController::class, 'siswaPerJurusan'])
    ->middleware(['auth', 'role:1,3'])
    ->name('siswa.per_jurusan');

Route::get('/guru/jurusan/{id}', [GuruPembimbingController::class, 'guruPerJurusan'])
    ->middleware(['auth', 'role:1'])
    ->name('guru.per_jurusan');


/*
|--------------------------------------------------------------------------
| NILAI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');

    // =========================
    // NILAI PKL
    // =========================


    Route::middleware(['auth'])->group(function () {

        Route::get('/siswa-by-nis-nilai/{nis}', [SiswaLookupController::class, 'byNisNilai'])
            ->name('siswa.byNisNilai');
    });

    // Guru Pembimbing & Admin → CRUD Nilai

    Route::middleware(['auth', 'role:3,5'])->group(function () {
        Route::get('/nilai/create', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/nilai/{nilai}/edit', [NilaiController::class, 'edit'])->name('nilai.edit');
        Route::put('/nilai/{nilai}', [NilaiController::class, 'update'])->name('nilai.update');
        Route::delete('/nilai/{nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    });


    // Siswa → hanya lihat nilai sendiri
    Route::middleware(['role:4'])->group(function () {
        Route::get('/nilai-saya', [NilaiController::class, 'index'])->name('nilai.saya');
    });
});


/*
|--------------------------------------------------------------------------
| JURNAL PKL
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal/create', [JurnalController::class, 'create'])->name('jurnal.create');
    Route::post('/jurnal', [JurnalController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal/{id}/edit', [JurnalController::class, 'edit'])->name('jurnal.edit');
    Route::put('/jurnal/{id}', [JurnalController::class, 'update'])->name('jurnal.update');
    Route::delete('/jurnal/{id}', [JurnalController::class, 'destroy'])->name('jurnal.destroy');

    // khusus guru pembimbing
    Route::put('/jurnal/{id}/status', [JurnalController::class, 'updateStatus'])
        ->name('jurnal.updateStatus');
});


//rout pencarian nama siswa di tabel Jurnal
Route::get('/api/siswa-by-nis/{nis}', function ($nis) {
    $siswa = Siswa::with('jurusan')->where('nis', $nis)->first();

    if (!$siswa) {
        return response()->json(['message' => 'Tidak ditemukan'], 404);
    }

    return response()->json([
        'id'      => $siswa->id,
        'nama'    => $siswa->nama,
        'jurusan' => $siswa->jurusan->nama_jurusan,
    ]);
});



//rout setuju guruPembimbing-jurnal
Route::put('/jurnal/{id}/setujui', [JurnalController::class, 'setujui'])
    ->name('jurnal.setujui')
    ->middleware(['auth', 'role:3,5']);


Route::get('/jurnal/jurusan/{id}', [JurnalController::class, 'jurnalPerJurusan'])
    ->middleware(['auth', 'role:1,3'])
    ->name('jurnal.per_jurusan');

Route::get('/jurnal/siswa/{id}', [JurnalController::class, 'jurnalPerSiswa'])
    ->middleware(['auth', 'role:4'])
    ->name('jurnal.per_siswa');


/*
|--------------------------------------------------------------------------
| NILAI
|--------------------------------------------------------------------------
*/
Route::get('/api/siswa-by-nis-nilai/${nis}', function ($nis) {
    $siswa = Siswa::with('jurusan')->where('nis', $nis)->first();
    $siswa = Siswa::with('gurupembimbing')->where('nis', $nis)->first();

    if (!$siswa) {
        return response()->json(['message' => 'Tidak ditemukan'], 404);
    }

    return response()->json([
        'id'      => $siswa->id,
        'nama'    => $siswa->nama,
        'jurusan' => $siswa->jurusan->nama_jurusan,
        'gurupembimbing' => $siswa->gurupembimbing->nama_guru,
    ]);
});

Route::get('/nilai/jurusan/{id}', [NilaiController::class, 'nilaiPerJurusan'])
    ->middleware(['auth', 'role:1,3'])
    ->name('nilai.per_jurusan');

Route::get('/nilai/siswa/{id}', [NilaiController::class, 'nilaiPerSiswa'])
    ->middleware(['auth', 'role:4'])
    ->name('nilai.per_siswa');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
