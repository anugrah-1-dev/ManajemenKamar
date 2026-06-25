<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\TransportsController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\Customer_Service_Controller;
use App\Http\Controllers\Admin\ProgramCampController;
use App\Http\Controllers\Admin\ProgramOfflineController;
use App\Http\Controllers\Admin\ProgramOnlineController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PendaftaranOnlineController;
use App\Http\Controllers\Admin\PendaftaranOfflineController;
use App\Http\Controllers\ProgramOfflinePublicController;
use App\Http\Controllers\ProgramOnlinePublicController;
use App\Http\Controllers\Admin\PeriodsController;
use App\Http\Controllers\Admin\SosmedController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PendaftaranProgramCampController;
use App\Http\Controllers\PendaftranCampController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\ThumbnailController;

use App\Http\Controllers\ProgramInggrisController;
use App\Http\Controllers\ProgramJermanController;
use App\Http\Controllers\ProgramArabController;
use App\Http\Controllers\ProgramMandarinController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProgramNHCController; // <-- PERUBAIKAN 1: Controller NHC ditambahkan
use App\Http\Controllers\Admin\PeriodNHCController;
use App\Http\Controllers\PelunasanController;
use App\Http\Controllers\DpController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
//camp
Route::get('/camps', [CampController::class, 'index'])->name('camps.index');
Route::get('/camps/{slug}', [CampController::class, 'show'])->name('camps.show');
Route::get('/camp/{slug}/room', [CampController::class, 'room'])->name('camp.room');
Route::get('/camp/{slug}', [CampController::class, 'show'])->name('camp.show.detail');


// Form pendaftaran awal
Route::get('/camp/{program}/daftar', [PendaftranCampController::class, 'showForm'])->name('camp.pendaftaran.form');
Route::post('/camp/{program}/daftar', [PendaftranCampController::class, 'store'])->name('camp.pendaftaran.store');

// Halaman pilih kamar berdasarkan trx_id
Route::get('/camp/room/{trx_id}', [PendaftranCampController::class, 'halamanKamar'])->name('camp.room.pilih');

Route::post('/camp/proses-kamar', [PendaftranCampController::class, 'proseskamaruser'])->name('camp.proseskamaruser');
Route::get('/camp/pembayaran/{trx_id}', [PendaftranCampController::class, 'halamanPembayaran'])->name('camp.pembayaran');
Route::post('/pembayaran/upload', [PendaftranCampController::class, 'uploadBukti'])->name('camp.payment.upload');



Route::bind('pendaftaran', function ($value) {
    return \App\Models\PendaftaranProgramCamp::where('trx_id', $value)->firstOrFail();
});

// Jika mau tetap pakai LandingPageController untuk tampilan awal bisa begini:
Route::get('/landing/program-offline/{program:slug}', [LandingPageController::class, 'showOfflinePublic'])->name('landing.program.offline.show');
Route::get('/landing/program-online/{program:slug}', [LandingPageController::class, 'showOnlinePublic'])->name('landing.program.online.show');

// === PROGRAM OFFLINE ===
Route::get('/program/offline/{program:slug}', [ProgramOfflinePublicController::class, 'showOfflinePublic'])->name('public.program.offline.show');
Route::post('/program/offline/{program:slug}/daftar', [ProgramOfflinePublicController::class, 'daftar'])->name('public.program.offline.daftar');
// Route Halaman Pembayaran Offline
Route::get('/pendaftaran/offline/pembayaran/{trx_id}', [ProgramOfflinePublicController::class, 'halamanPembayaran'])->name('public.pendaftaran.offline.pembayaran');
// ROUTE BARU: Halaman sukses untuk pembayaran tunai
Route::get('/pendaftaran/offline/sukses-tunai/{trx_id}', [ProgramOfflinePublicController::class, 'halamanSuksesTunai'])->name('public.pendaftaran.offline.sukses.tunai');

Route::get('/pendaftaran/offline/qris/{trx_id}', [ProgramOfflinePublicController::class, 'halamanqris'])->name('public.pendaftaran.offline.sukses.qris');


// === PROGRAM ONLINE ===
Route::get('/program/online/{program:slug}', [ProgramOnlinePublicController::class, 'show'])
    ->name('public.program.online.show');
Route::post('/program/online/{program:slug}/daftar', [ProgramOnlinePublicController::class, 'daftar'])
    ->name('public.program.online.daftar');
// Route Halaman Pembayaran Online
Route::get('/pendaftaran/online/pembayaran/{trx_id}', [ProgramOnlinePublicController::class, 'halamanPembayaran'])->name('public.pendaftaran.online.pembayaran');
// ROUTE BARU: Halaman sukses untuk pembayaran tunai
Route::get('/pendaftaran/online/sukses-tunai/{trx_id}', [ProgramOnlinePublicController::class, 'halamanSuksesTunai'])->name('public.pendaftaran.online.sukses.tunai');
Route::get('/pendaftaran/online/qris/{trx_id}', [ProgramOnlinePublicController::class, 'halamanqris'])->name('public.pendaftaran.online.sukses.qris');




Route::get('/program/bahasa/inggris', [ProgramInggrisController::class, 'showInggris'])
    ->name('program.inggris');

Route::get('/program/bahasa/jerman', [ProgramJermanController::class, 'showJerman'])->name('program.jerman');


// Route baru
Route::get('/brilliantalsaeidarabic', [ProgramArabController::class, 'showArab'])->name('program.arab');

// Redirect dari URL lama ke URL baru
Route::redirect('/program/bahasa/arab', '/brilliantalsaeidarabic');


// Definisikan route untuk URL BARU yang Anda inginkan
Route::get('/MandarinCenterPare', [ProgramMandarinController::class, 'showMandarin'])->name('program.mandarin');

// Alihkan (redirect) URL LAMA ke URL BARU dengan status 301 (Moved Permanently)
Route::redirect('/program/bahasa/mandarin', '/MandarinCenterPare', 301);

// PERUBAIKAN 2: Rute NHC diubah ke controller yang benar
// ===============================================
Route::get('/nhc', [ProgramNHCController::class, 'index'])->name('landing.nhc');

// ===== ROUTE UNTUK UPLOAD BUKTI PEMBAYARAN =====
Route::post('/payment/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload');

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/tracking', [TrackingController::class, 'search'])->name('tracking.search');
Route::get('/tracking/tagihan/{trx_id}', [TrackingController::class, 'show'])->name('tracking.show');
// Halaman pelunasan semua cicilan berdasarkan pendaftaran

Route::get('/cicilan/{trx_id}/pelunasan', [PelunasanController::class, 'show'])
    ->name('cicilan.pelunasan');

// pelunasan semua cicilan berdasarkan pendaftaran
Route::post('/cicilan/{trx_id}/pelunasan', [PelunasanController::class, 'store'])
    ->name('cicilan.pelunasan.store');
Route::post('/tracking/{trx_id}', [TrackingController::class, 'update'])->name('tracking.update');

// Upload bukti DP
Route::post('/dp/store', [DpController::class, 'store'])->name('payment.dp.store');
Route::get('/dp/{id}', [DpController::class, 'show'])->name('payment.dp.show');
// Halaman DP
Route::get('/pendaftaran/offline/{trx_id}/dp', [DpController::class, 'dp'])
    ->name('public.pendaftaran.offline.dp');

// Upload bukti DP
Route::post('/dp/store', [DpController::class, 'store'])->name('dp.store');

// Halaman utama
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


//Landing page
Auth::routes();

Route::middleware(['auth', 'role:admin|officer'])->prefix('admin')->name('admin.')->group(function () {

    //dashboard admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/stok', [DashboardController::class, 'dashboardStok'])->name('admin.dashboard.stok');

    //roles
    Route::resource('roles', RoleController::class);
    //permissions
    Route::resource('permissions', PermissionController::class);
    //users
    Route::resource('users', UserController::class);
    //banks
    Route::resource('banks', BankController::class);
    //transports
    Route::resource('transports', TransportsController::class);
    //cs
    Route::resource('customer_services', Customer_Service_Controller::class);

    // Pamflet
    Route::get('pamflet_programs', [ProgramController::class, 'index'])->name('pamflet_programs.index');
    Route::get('pamflet_programs/create', [ProgramController::class, 'create'])->name('pamflet_programs.create');
    Route::post('pamflet_programs', [ProgramController::class, 'store'])->name('pamflet_programs.store');
    Route::get('pamflet_programs/{program}', [ProgramController::class, 'show'])->name('pamflet_programs.show');
    Route::get('pamflet_programs/{program}/edit', [ProgramController::class, 'edit'])->name('pamflet_programs.edit');
    Route::put('pamflet_programs/{program}', [ProgramController::class, 'update'])->name('pamflet_programs.update');
    Route::delete('pamflet_programs/{program}', [ProgramController::class, 'destroy'])->name('pamflet_programs.destroy');

    //program offline
    Route::resource('programs/offline', ProgramOfflineController::class);
    Route::delete('admin/programs/offline/{id}', [ProgramOfflineController::class, 'destroy'])->name('admin.offline.destroy');

    //program online
    Route::resource('programs/online', ProgramOnlineController::class);

    // gallery
    Route::resource('galleries', GalleryController::class);
    Route::delete('galleries/images/{id}', [GalleryController::class, 'destroyImage'])->name('galleries.images.destroy');

    //program camp
    Route::resource('programs/camp', ProgramCampController::class)->names('programs.camp');
    Route::post('/programs/camp/sync-all-stok-from-rooms', [ProgramCampController::class, 'syncAllStokFromRoomsAjax'])->name('programs.camp.syncAllStokFromRoomsAjax');

    Route::post('/programs/camp/sync-stok', [ProgramCampController::class, 'syncStokWithPenghuni'])->name('programs.camp.syncStokWithPenghuni');
    Route::delete('/thumbnails/{thumbnail}', [ThumbnailController::class, 'destroy'])
        ->name('thumbnails.destroy');


    Route::resource('rooms', RoomController::class);
    Route::get('/rooms/{id}/penghuni', [RoomController::class, 'getPenghuni']);
    Route::delete('/rooms/penghuni/{trx_id}', [RoomController::class, 'kickPenghuni']);
    Route::post('/rooms/pindah-peserta', [RoomController::class, 'pindahPeserta']);
    Route::get('/rooms/list-aktif', [RoomController::class, 'listAktif']);
    Route::get('/rooms/{id}/peserta-detail', [RoomController::class, 'getPesertaDetail']);
    Route::post('/peserta/{id}/pindah-kamar', [PendaftaranProgramCampController::class, 'pindahKamar']);
    Route::post('/rooms/update-by-kategori', [RoomController::class, 'updateByKategori'])
        ->name('rooms.update-by-kategori');
    Route::post('/rooms/sync-penghuni', [PendaftaranProgramCampController::class, 'syncPenghuniFromRoomsAjax'])->name('rooms.sync-penghuni');

    //CSV Export
    Route::get('/pendaftaran/online/export', [PendaftaranOnlineController::class, 'exportOnline'])->name('pendaftaran.online.export');

    Route::get('/pendaftaran/offline/export', [PendaftaranOfflineController::class, 'export'])->name('pendaftaran.offline.export');

    Route::get('/pendaftaran/camp/export', [PendaftaranProgramCampController::class, 'exportCamp'])->name('pendaftaran.camp.export');

    // Pembayaran

    // Pendaftaran Program Online
    Route::get('pendaftaran/online', [PendaftaranOnlineController::class, 'index'])->name('pendaftaran.online.index');
    Route::get('pendaftaran/online/{id}/edit', [PendaftaranOnlineController::class, 'edit'])->name('pendaftaran.online.edit');
    Route::put('pendaftaran/online/{id}', [PendaftaranOnlineController::class, 'update'])->name('pendaftaran.online.update');
    Route::delete('pendaftaran/online/{id}', [PendaftaranOnlineController::class, 'destroy'])->name('pendaftaran.online.destroy');
    Route::get('pendaftaran/online/{id}/bukti', [PendaftaranOnlineController::class, 'showBukti'])->name('pendaftaran.online.bukti');
    Route::get('/pendaftaran/program-online', [PendaftaranOnlineController::class, 'create'])->name('pendaftaran.program_online.create');
    Route::post('/pendaftaran/program-online', [PendaftaranOnlineController::class, 'store'])->name('pendaftaran.program_online.store');

    // Pendaftaran Program Offline
    Route::get('pendaftaran/offline', [PendaftaranOfflineController::class, 'index'])->name('pendaftaran.offline.index');
    Route::get('pendaftaran/offline/{id}', [PendaftaranOfflineController::class, 'show'])->name('pendaftaran.offline.show');
    Route::get('pendaftaran/offline/{id}/edit', [PendaftaranOfflineController::class, 'edit'])->name('pendaftaran.offline.edit');
    Route::put('pendaftaran/offline/{id}', [PendaftaranOfflineController::class, 'update'])->name('pendaftaran.offline.update');
    Route::delete('pendaftaran/offline/{id}', [PendaftaranOfflineController::class, 'destroy'])->name('pendaftaran.offline.destroy');
    Route::get('pendaftaran/offline/{id}/bukti', [PendaftaranOfflineController::class, 'showBukti'])->name('pendaftaran.offline.bukti');
    Route::get('/pendaftaran/program-offline', [PendaftaranOfflineController::class, 'create'])->name('pendaftaran.program_offline.create');
    Route::post('/pendaftaran/program-offline', [PendaftaranOfflineController::class, 'store'])->name('pendaftaran.program_offline.store');

    // Pendaftaran Program Camp
    Route::get('/pendaftaran/camp', [PendaftaranProgramCampController::class, 'index'])->name('pendaftaran.camp.index');
    Route::get('/pendaftaran/camp/{id}/edit', [PendaftaranProgramCampController::class, 'edit'])->name('pendaftaran.camp.edit');
    Route::put('/pendaftaran/camp/{id}', [PendaftaranProgramCampController::class, 'update'])->name('pendaftaran.camp.update');
    Route::delete('/pendaftaran/camp/{id}', [PendaftaranProgramCampController::class, 'destroy'])->name('pendaftaran.camp.destroy');
    Route::get('/pendaftaran/camp/{id}/bukti', [PendaftaranProgramCampController::class, 'showBukti'])->name('pendaftaran.camp.bukti');


    //periods
    Route::resource('periods', PeriodsController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::resource('periods_nhc', PeriodNHCController::class);

    //sosmed
    Route::resource('sosmed', SosmedController::class);

    Route::put('/admin/pendaftaran/camp/update-status/{id}', [PendaftaranProgramCampController::class, 'updateStatus'])->name('pendaftaran.camp.update-status');


    // Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    // Route::post('/upload-bukti', [PembayaranController::class, 'uploadBukti'])->name('bukti.upload');

});
