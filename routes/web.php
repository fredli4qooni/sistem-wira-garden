<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MidtransWebhookController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinasi', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinasi/{id}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/fasilitas', [App\Http\Controllers\FacilityController::class, 'index'])->name('facilities.index');
Route::get('/tiket', [App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\UserController;

Route::get('/api/check-stock', function (Illuminate\Http\Request $request) {
    $destination = \App\Models\Destination::find($request->destination_id);
    if (!$destination) return response()->json(['available_stock' => null]);
    
    $stock = $destination->getAvailableStock($request->visit_date);
    return response()->json(['available_stock' => $stock]);
})->name('api.check-stock');

Route::middleware('auth')->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservasi/{order:order_code}/payment', [ReservationController::class, 'payment'])->name('reservations.payment');
    Route::get('/reservasi/{order:order_code}/success', [ReservationController::class, 'success'])->name('reservations.success');
    Route::get('/reservasi/{order:order_code}/ticket', [ReservationController::class, 'downloadTicket'])->name('reservations.ticket');
    
    Route::get('/riwayat-pesanan', [App\Http\Controllers\User\OrderController::class, 'index'])->name('user.orders.index');
    Route::get('/riwayat-pesanan/{order:order_code}', [App\Http\Controllers\User\OrderController::class, 'show'])->name('user.orders.show');
});

Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle'])->name('webhook.midtrans');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order:id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('destinations', AdminDestinationController::class);
    Route::resource('galleries', AdminGalleryController::class);
    Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('users', UserController::class)->except('show');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('settings.store');
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.exportPdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
