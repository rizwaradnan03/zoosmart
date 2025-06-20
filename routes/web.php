<?php

use App\Http\Controllers\admin\HewanController as AdminHewanController;
use App\Http\Controllers\admin\PerawatanController as AdminPerawatanController;
use App\Http\Controllers\admin\TiketController as AdminTiketController;
use App\Http\Controllers\admin\PembelianController as AdminPembelianController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentGatewayController;
use App\Models\Hewan;
use App\Models\Pembelian;
use App\Models\Perawatan;
use App\Models\Tiket;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('index');

Route::get('/activities', function () {
    return view('activities');
})->name('activities');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/animal', function () {
    $hewans = Hewan::all();

    return view('animal', compact('hewans'));
})->name('animal');

Route::get('login-page', [AuthController::class, 'login_page'])->name('auth.login-page');
Route::get('register-page', [AuthController::class, 'register_page'])->name('auth.register-page');

Route::get('checkout-page', function(){
    $tikets = Tiket::where('is_used', false)->get();

    return view('pengunjung.checkout', compact('tikets'));
})->name('pengunjung.checkout-page');

Route::post('checkout', [PaymentGatewayController::class, 'checkout'])->name('payment.checkout');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::prefix('petugas')->middleware(['auth'])->as('petugas.')->group(function () {
    Route::get('dashboard', function () {
        $pembelians = Pembelian::where('status_transaksi', 'settlement')->get();

        $total_pembelian = 0;

        for($i = 0;$i < sizeof($pembelians);$i++){
            $total_pembelian += $pembelians[$i]->tiket->harga;
        }

        $hewans = Hewan::all();
        $total_hewan = sizeof($hewans);

        $perawatans = Perawatan::all();
        $total_perawatan = sizeof($perawatans);

        return view('petugas.dashboard.index', compact('total_pembelian', 'total_hewan', 'total_perawatan'));
    })->name('dashboard.index');

    Route::resource('hewan', AdminHewanController::class);
    Route::resource('perawatan', AdminPerawatanController::class);
    Route::resource('pembelian', AdminPembelianController::class);
    Route::resource('tiket', AdminTiketController::class);
});
