<?php

use App\Http\Controllers\DaftarTagihanController;
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
})->name("home");


Route::resource("user", UserController::class);
Route::get("user/restore/{user}", function ($user) {
    $getUser = User::withTrashed()
        ->where('id', $user);
    $restore = $getUser->restore();

    return back()->with("success", "User " . $getUser->first()->name . " Berhasil Di Aktifkan Kembali");
})->name("user.restore");

Route::prefix('tagihan')->group(function () {

    Route::resource("tagihanSiswa", TagihanController::class);
    Route::get("tagihanSiswa/restore/{tagihanSiswa}", [TagihanController::class, 'restore'])->name("tagihanSiswa.restore");

    Route::resource("Transaksi", TransaksiController::class);
    Route::get("Transaksi/restore/{Transaksi}", [TransaksiController::class, 'restore'])->name("Transaksi.restore");

    Route::resource("daftarTagihan", DaftarTagihanController::class);
    Route::get("daftarTagihan/restore/{daftarTagihan}", [DaftarTagihanController::class, 'restore'])->name("daftarTagihan.restore");
});
