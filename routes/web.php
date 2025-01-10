<?php

use App\Http\Controllers\DaftarTagihanController;
use App\Http\Controllers\MethodePembayaranController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;

use App\Models\User;
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
    return view('dashboard', [
        "title" => "Dashboard"
    ]);
})->name("home")->middleware("auth.basic");


Route::resource("user", UserController::class)->middleware("auth.basic");
Route::get("user/restore/{user}", function ($user) {
    $getUser = User::withTrashed()
        ->where('id', $user);
    $restore = $getUser->restore();

    return back()->with("success", "User " . $getUser->first()->name . " Berhasil Di Aktifkan Kembali")->middleware("auth.basic");
})->name("user.restore")->middleware("auth.basic");

Route::prefix('tagihan')->group(function () {

    Route::resource("tagihanSiswa", TagihanController::class)->middleware("auth.basic");
    Route::get("tagihanSiswa/restore/{tagihanSiswa}", [TagihanController::class, 'restore'])->name("tagihanSiswa.restore")->middleware("auth.basic");

    Route::resource("Transaksi", TransaksiController::class)->middleware("auth.basic");
    Route::get("Transaksi/restore/{Transaksi}", [TransaksiController::class, 'restore'])->name("Transaksi.restore")->middleware("auth.basic");

    Route::resource("MethodePembayaran", MethodePembayaranController::class)->middleware("auth.basic");
    Route::get("MethodePembayaran/restore/{MethodePembayaran}", [MethodePembayaranController::class, 'restore'])->name("MethodePembayaran.restore")->middleware("auth.basic");

    Route::resource("daftarTagihan", DaftarTagihanController::class)->middleware("auth.basic");
    Route::get("daftarTagihan/restore/{daftarTagihan}", [DaftarTagihanController::class, 'restore'])->name("daftarTagihan.restore")->middleware("auth.basic");
});
