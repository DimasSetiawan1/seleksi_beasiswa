<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\AHPController;
use App\Http\Controllers\Admin\MOORAController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboard;
use App\Http\Controllers\Kepsek\ProposalController;

use App\Http\Controllers\Ortu\DashboardController as OrtuDashboard;
use App\Http\Controllers\Ortu\RegistrationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'kepsek') return redirect()->route('kepsek.dashboard');
    return redirect()->route('ortu.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin / Panitia Beasiswa Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('kriteria', CriteriaController::class);
    Route::get('/ahp', [AHPController::class, 'index'])->name('ahp.index');
    Route::post('/ahp/calculate', [AHPController::class, 'calculate'])->name('ahp.calculate');
    Route::get('/moora', [MOORAController::class, 'index'])->name('moora.index');
    Route::post('/moora/calculate', [MOORAController::class, 'calculate'])->name('moora.calculate');
    Route::post('/moora/send', [MOORAController::class, 'sendProposal'])->name('moora.send');
    Route::get('/kandidat', [CandidateController::class, 'index'])->name('kandidat.index');
    Route::get('/kandidat/{id}', [CandidateController::class, 'show'])->name('kandidat.show');
    Route::post('/kandidat/{id}/verify', [CandidateController::class, 'verify'])->name('kandidat.verify');
    Route::post('/kandidat/{id}/score', [CandidateController::class, 'storeScore'])->name('kandidat.score');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [ReportController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/export-excel', [ReportController::class, 'exportExcel'])->name('laporan.excel');
});

// Kepsek Routes
Route::middleware(['auth', 'verified', 'role:kepsek'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', [KepsekDashboard::class, 'index'])->name('dashboard');
    Route::get('/usulan', [ProposalController::class, 'index'])->name('usulan.index');
    Route::post('/usulan/{id}/approve', [ProposalController::class, 'approve'])->name('usulan.approve');
    Route::post('/usulan/{id}/reject', [ProposalController::class, 'reject'])->name('usulan.reject');
});

// Orang Tua / Wali Routes
Route::middleware(['auth', 'verified', 'role:ortu'])->prefix('ortu')->name('ortu.')->group(function () {
    Route::get('/dashboard', [OrtuDashboard::class, 'index'])->name('dashboard');
    Route::get('/pendaftaran', [RegistrationController::class, 'index'])->name('pendaftaran.index');
    Route::post('/pendaftaran/store', [RegistrationController::class, 'store'])->name('pendaftaran.store');
    Route::post('/pendaftaran/upload', [RegistrationController::class, 'upload'])->name('pendaftaran.upload');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
