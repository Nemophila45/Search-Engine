<?php

use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitorNoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Tes OK';
});

// Redirect root ke daftar pasien
Route::redirect('/', '/patients');

// Halaman publik catatan pengunjung
Route::get('/visitor-notes', [VisitorNoteController::class, 'index'])->name('visitor-notes.index');

// ======== Guest (belum login) ========
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// ======== Logout (khusus user login) ========
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ======== Staff Access ========
Route::middleware('auth')->group(function (): void {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});

// ======== Record Management ========
Route::middleware(['auth', 'role:admin,doctor,koas'])->group(function (): void {
    Route::get('/patients/{patient}/records/create', [PatientController::class, 'createRecord'])
        ->name('patients.records.create');
    Route::post('/patients/{patient}/records', [PatientController::class, 'storeRecord'])
        ->name('patients.records.store');
    Route::get('/patients/{patient}/records/{medicalRecord}/download', [PatientController::class, 'downloadRecord'])
        ->name('patients.records.download');
});

Route::middleware(['auth', 'role:admin,doctor'])->group(function (): void {
    Route::get('/patients/{patient}/records/{medicalRecord}/edit', [PatientController::class, 'editRecord'])
        ->name('patients.records.edit');
    Route::put('/patients/{patient}/records/{medicalRecord}', [PatientController::class, 'updateRecord'])
        ->name('patients.records.update');
    Route::delete('/patients/{patient}/records/{medicalRecord}', [PatientController::class, 'destroyRecord'])
        ->name('patients.records.destroy');
});

// ======== Admin User Management ========
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
        Route::delete('/history', [HistoryController::class, 'destroy'])->name('history.destroy');
        Route::get('/reports/disease-chart', [ReportController::class, 'diseaseChart'])->name('reports.disease-chart');
    });
