<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataSourceController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\PageAccessController;
use App\Http\Controllers\Admin\PageDataSyncController;
use App\Http\Controllers\Admin\ProgressItemController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatCardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes (PLN UPT Manado Web)
|--------------------------------------------------------------------------
*/
Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/kinerja-transmisi', [WebController::class, 'kinerjaTransmisi'])->name('kinerja-transmisi');
Route::get('/anggaran', [WebController::class, 'anggaran'])->name('anggaran');
Route::post('/anggaran/verify-access', [WebController::class, 'verifyAnggaranAccess'])->name('anggaran.verify');
Route::post('/anggaran/lock-access', [WebController::class, 'lockAnggaranAccess'])->name('anggaran.lock');

// Universal Page Access Verification
Route::post('/page-access/verify', [WebController::class, 'verifyPageAccess'])->name('page-access.verify');
Route::post('/page-access/lock', [WebController::class, 'lockPageAccess'])->name('page-access.lock');
Route::post('/page-access/ping', [WebController::class, 'pingPageAccess'])->name('page-access.ping');

// Reliable CSV Data Source Proxy (fallback for CORS / network constraints)
Route::get('/api/proxy-csv', [WebController::class, 'proxyCsv'])->name('api.proxy-csv');

Route::get('/ahi', [WebController::class, 'ahi'])->name('ahi');
Route::get('/common-enemy', [WebController::class, 'commonEnemy'])->name('common-enemy');
Route::get('/abo', [WebController::class, 'abo'])->name('abo');
Route::get('/aset', [WebController::class, 'aset'])->name('aset');
Route::get('/konstruksi-penyaluran', [WebController::class, 'konstruksiPenyaluran'])->name('konstruksi-penyaluran');
Route::get('/kku', [WebController::class, 'kku'])->name('kku');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // General & Branding Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Section Visibility & Titles
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::post('/sections/{section}/toggle', [SectionController::class, 'toggle'])->name('sections.toggle');

    // Stat Cards (Asset counters, KKU counters, etc.)
    Route::post('/stat-cards/sync-all', [StatCardController::class, 'syncAll'])->name('stat-cards.sync-all');
    Route::post('/stat-cards/test-mapping', [StatCardController::class, 'testMapping'])->name('stat-cards.test-mapping');
    Route::post('/stat-cards/{statCard}/sync', [StatCardController::class, 'sync'])->name('stat-cards.sync');
    Route::post('/stat-cards/{statCard}/quick-update', [StatCardController::class, 'quickUpdate'])->name('stat-cards.quick-update');
    Route::post('/stat-cards/{statCard}/reset-remote', [StatCardController::class, 'resetToRemote'])->name('stat-cards.reset-remote');
    Route::resource('stat-cards', StatCardController::class)->except(['show']);

    // Progress items (Konstruksi, COD, STO, etc.)
    Route::resource('progress', ProgressItemController::class)->except(['show']);

    // Data Sources (Google Sheets CSV endpoints & Local CSV files)
    Route::resource('data-sources', DataSourceController::class)
        ->except(['show'])
        ->parameters(['data-sources' => 'dataSource']);
    Route::post('/data-sources/{dataSource}/test', [DataSourceController::class, 'test'])->name('data-sources.test');

    // Settingan Keseluruhan Halaman & Sinkronisasi Data 2-Arah (Web <-> CSV/Sheet)
    Route::get('/page-data', [PageDataSyncController::class, 'index'])->name('page-data.index');
    Route::get('/page-data/{key}/edit', [PageDataSyncController::class, 'edit'])->name('page-data.edit');
    Route::post('/page-data/{key}/save', [PageDataSyncController::class, 'save'])->name('page-data.save');
    Route::post('/page-data/{key}/pull', [PageDataSyncController::class, 'pullFromSheet'])->name('page-data.pull');
    Route::post('/page-data/{key}/reset-live', [PageDataSyncController::class, 'resetToLiveSheet'])->name('page-data.reset-live');
    Route::get('/page-data/{key}/download', [PageDataSyncController::class, 'download'])->name('page-data.download');
    Route::post('/page-data/{key}/upload', [PageDataSyncController::class, 'upload'])->name('page-data.upload');

    // Navigation Menu items
    Route::resource('navigation', NavigationController::class)->except(['show']);

    // Kelola Akun Admin Web
    Route::resource('users', UserController::class)->except(['show']);

    // Akses Terbatas Halaman (Page Access Modes & Personnel Accounts)
    Route::get('/page-access', [PageAccessController::class, 'index'])->name('page-access.index');
    Route::post('/page-access/settings/{slug}/toggle', [PageAccessController::class, 'toggleSetting'])->name('page-access.settings.toggle');
    Route::get('/page-access/accounts/create', [PageAccessController::class, 'createAccount'])->name('page-access.accounts.create');
    Route::post('/page-access/accounts', [PageAccessController::class, 'storeAccount'])->name('page-access.accounts.store');
    Route::get('/page-access/accounts/{account}/edit', [PageAccessController::class, 'editAccount'])->name('page-access.accounts.edit');
    Route::put('/page-access/accounts/{account}', [PageAccessController::class, 'updateAccount'])->name('page-access.accounts.update');
    Route::post('/page-access/accounts/{account}/toggle', [PageAccessController::class, 'toggleAccount'])->name('page-access.accounts.toggle');
    Route::delete('/page-access/accounts/{account}', [PageAccessController::class, 'destroyAccount'])->name('page-access.accounts.destroy');
});
