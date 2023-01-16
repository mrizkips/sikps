<?php

use App\Http\Controllers\AkademikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalPendaftaranController;
use App\Http\Controllers\KpSkripsiController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('/users/{user}/update_password', [UserController::class, 'updatePassword'])->name('users.update_password');
    Route::post('/users/import/dosen', [UserController::class, 'importDosen'])->name('users.importDosen');
    Route::resource('users', UserController::class);

    Route::resource('tahun_akademik', TahunAkademikController::class)->only('create', 'destroy', 'store');

    Route::resource('jadwal_pendaftaran', JadwalPendaftaranController::class)->except('show');

    Route::get('/proposal/{proposal}/download', [ProposalController::class, 'download'])->name('proposal.download');
    Route::get('/proposal/{proposal}/send', [ProposalController::class, 'send'])->name('proposal.send');
    Route::resource('proposal', ProposalController::class);

    Route::post('/pengajuan/{pengajuan}/accept', [PengajuanController::class, 'accept'])->name('pengajuan.accept');
    Route::post('/pengajuan/{pengajuan}/reject', [PengajuanController::class, 'reject'])->name('pengajuan.reject');
    Route::post('/pengajuan/{pengajuan}/pay', [PengajuanController::class, 'pay'])->name('pengajuan.pay');
    Route::post('/pengajuan/{pengajuan}/activate', [PengajuanController::class, 'activate'])->name('pengajuan.activate');
    Route::resource('pengajuan', PengajuanController::class)->except('update', 'edit', 'create');

    Route::post('kp_skripsi/{kp_skripsi}/assignDosen', [KpSkripsiController::class, 'assignDosen'])->name('kp_skripsi.assign_dosen');
    Route::post('kp_skripsi/{kp_skripsi}/printFormBimbingan', [KpSkripsiController::class, 'printFormBimbingan'])->name('kp_skripsi.print_form_bimbingan');
    Route::resource('kp_skripsi', KpSkripsiController::class)->only('index', 'show');
});
