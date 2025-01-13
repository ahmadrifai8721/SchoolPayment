<?php

use App\Models\AnggotaKelas;
use App\Models\DaftarTagihan;
use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Auth;
use App\Models\MethodePembayaran;
use Midtrans\Snap;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


route::post("User/{code}", function ($code) {
    if ($code == "koalaToken") {

        $userID = null;

        $urlRombel = "http://" . env("DAPODIK_SERVER_IP") . ":" . env("DAPODIK_SERVER_PORT") .
            "/WebService/getRombonganBelajar?npsn=" .
            env("DAPODIK_SERVER_NPSN");
        $getBodyRombel = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('DAPODIK_SERVER_Token'),
        ])->get($urlRombel)->body();

        $getBodyRombel = json_decode($getBodyRombel);
        $getBodyRombel = $getBodyRombel->rows;

        foreach ($getBodyRombel as $key => $value) {
            if ($value->jenis_rombel == "1") {
                $kelas = Kelas::updateOrCreate(["rombongan_belajar_id" => $value->rombongan_belajar_id], [
                    "rombongan_belajar_id" => $value->rombongan_belajar_id,
                    "kelas" => $value->nama,
                ]);
            }
        }

        $url = "http://" . env("DAPODIK_SERVER_IP") . ":" . env("DAPODIK_SERVER_PORT") .
            "/WebService/getPesertaDidik?npsn=" .
            env("DAPODIK_SERVER_NPSN");
        $getBody = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('DAPODIK_SERVER_Token'),
        ])->get($url)->body();
        $log = [
            "title" => "Selesai mengunduh Data Siswa Dari Dapodik",
            "icon" => "mdi-database-arrow-down-outline",
            "icon_color" => "success",
            "time" => date("H:i:s:u"),
        ];

        $getBody = json_decode($getBody);
        $getBody = $getBody->rows;

        foreach ($getBody as $key => $value) {
            $userID = User::updateOrCreate(["email" => $value->nisn . "@siswa.schpay.com"], [
                "name" => $value->nama,
                "nisn" => $value->nisn,
                "jk" => $value->jenis_kelamin,
                "tempatLahir" => $value->tempat_lahir,
                "tanggalLahir" => $value->tanggal_lahir,
                "email" => $value->nisn . "@siswa.schpay.com",
                "nomerHP" => $value->nomor_telepon_seluler,
                "alamat" => "Alamat Belum Diatur",
                "isAdmin" => false,
                "password" => bcrypt($value->nisn),
            ]);
            AnggotaKelas::updateOrCreate([
                "rombongan_belajar_id" => $value->rombongan_belajar_id,
                "user_id" => $userID->id,
            ], [
                "rombongan_belajar_id" => $value->rombongan_belajar_id,
                "user_id" => $userID->id,
            ]);
        }


        return response()->json([
            "statusCode" => 200,
            "message" => "Selesai Import Data Dari dapodik"
        ]);
    } else {
        return response()->json([
            "statusCode" => 401,
            "message" => "Invalid credentials"
        ], 401);
    }
})->name("apiUserImport");
Route::get(
    "User/{code}",
    function ($code) {
        if ($code == "koalaToken") {

            $data = [];
            $totalTagihan = 0;
            $getUser = User::withTrashed()->get();
            foreach ($getUser as $key => $value) {
                # code...
                # code...
                foreach ($value->Tagihan as $key => $tagihan) {
                    $totalTagihan = $tagihan->DaftarTagihan->sum('nominal');
                }
                // dump();
                $data["data"][] = [
                    $value->trashed() ? "$value->name <strong class='badge bg-danger'>Akun Terblokir</strong>" : $value->name,
                    $value->isAdmin ? "Administrator" : $value->AnggotaKelas->Kelas->kelas,
                    Number::currency($totalTagihan, "IDR"),
                    Number::currency($value->Transaksi->where('status', "1")->sum("total"), "IDR"),
                    $value->trashed() ? '
                    <a href="#' . $value->name . '" class="action-icon"> <i class="uil-invoice"></i></a>
                    <a href="' . route("user.show", $value->id) . '" class="action-icon"> <i class="uil-user"></i></a>
                    <a href="' . route("user.restore", $value->id) . '" class="action-icon"> <i class="mdi mdi-delete-restore"></i></a>'
                        : '
                        <a href="' . $value->name . '" class="action-icon"> <i class="uil-invoice"></i></a>
                        <a href="' . route("user.show", $value->id) . '" class="action-icon"> <i class="uil-user"></i></a>'
                ];
                $totalTagihan = 0;
            }

            $data["draw"] = 1;
            $data["recordsTotal"] = User::count();
            $data["recordsFiltered"] = User::count();

            return response()->json($data);
        } else {
            return response()->json([
                "statusCode" => 401,
                "message" => "Invalid credentials"
            ], 401);
        }
    }
)->name("apiUser");

Route::prefix("mobile")->middleware("auth:sanctum")->group(function () {

    Route::get("transaksi", function (Request $request) {
        if ($request->user()->isAdmin) {
            $transaksi = Transaksi::all();
            // dd($transaksi);
            $data = [];
            foreach ($transaksi as $key => $value) {
                # code...
                $data[$key] = [
                    'id' => $value->id,
                    'username' => $request->user()->name,
                    'tanggal' => $value->tanggal,
                    'methodePembayran' => $value->MethodePembayaran->nama,
                    'namaTagihan' => $value->Tagihan->nama,
                    'fee' => $value->fee,
                    'total' => $value->total,
                    'snapToken' => $value->snapToken,
                    'order_id' => $value->order_id,
                    'status' => ($value->status == 1) ? "Successful" : (($value->status == 2) ? "Menunggu Pembayaran" : (($value->status == 3) ? "VA Ssudah Di Buat" : "Transasi di Batalkan")),
                ];
            };
        } else {
            $transaksi = $request->user()->Transaksi;
            // dd($transaksi);
            $data = [];
            foreach ($transaksi as $key => $value) {
                # code...
                $data[$key] = [
                    'id' => $value->id,
                    'username' => $request->user()->name,
                    'tanggal' => $value->tanggal,
                    'methodePembayran' => $value->MethodePembayaran->nama,
                    'namaTagihan' => $value->DaftarTagihan->nama,
                    'fee' => $value->fee,
                    'total' => $value->total,
                    'snapToken' => $value->snapToken,
                    'order_id' => $value->order_id,
                    'status' => ($value->status == 1) ? "Successful" : (($value->status == 2) ? "Menunggu Pembayaran" : (($value->status == 3) ? "VA Ssudah Di Buat" : "Transasi di Batalkan")),
                ];
            }
        }
        return response()->json($data);
    });
    Route::get("tagihan", function (Request $request) {
        if ($request->user()->isAdmin) {
            $tagihan = Tagihan::all();
            foreach ($tagihan as $key => $value) {
                # code...
                $data[$key] = [
                    "id" => $value->id,
                    "nama" => $value->nama,
                    "username" => $value->User->name,
                    "nominal" => $value->DaftarTagihan->nominal,
                    "terbayar" => $value->Transaksi->where("status", 1)->sum("total"),
                    "Status" => $value->status,
                ];
            }
        } else {

            $tagihan = $request->user()->tagihan;
            foreach ($tagihan as $key => $value) {
                # code...
                $data[$key] = [
                    "id" => $value->id,
                    "nama" => $value->nama,
                    "username" => $value->User->name,
                    "nominal" => $value->DaftarTagihan->nominal,
                    "terbayar" => $value->Transaksi->where("status", 1)->sum("total"),
                    "Status" => $value->status,
                ];
            }
        }
        return response()->json($data);
    });
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::get('user/tagihan', function (Request $request) {
        // dd($request->nisn);
        return response()->json(User::where("nisn", $request->nisn)->first()->Tagihan->where("status", 0)->all());
    });
    Route::get('user/all', function (Request $request) {
        return User::where("isAdmin", "0")->get(["id", "name", "nisn"]);
    });
    Route::post('payment', function (Request $request) {

        $methode = MethodePembayaran::find($request->input('methode_pembayaran_id'));

        if ($methode->type == "offline") {
            # code...
            // dd($methode);
            $fee = $methode->percent == 1 ? ($request->input("total") * $methode->biayaTransaksi / 100) : $request->input("total") + $methode->biayaTransaksi;
            $total = $request->input("total") + $fee;
            # code...
            $tagihan = Tagihan::find($request->tagihan_id);
            $data = [
                "user_id" =>  User::where("nisn", $request->input('user_id'))->first()->id,
                "tanggal" => now(),
                "methode_pembayaran_id" => $methode->id,
                "tagihan_id" => $request->tagihan_id,
                "fee" => $fee,
                "total" => $total,
                "status" => 1,
            ];
            Transaksi::create($data);
            // dd($tagihan->DaftarTagihan->nominal);
            if ($tagihan->DaftarTagihan->nominal <= $request->input("total")) {
                # code...
                $tagihan->update([
                    "status" => 1
                ]);
            }

            return response()->json([
                "message" => "success"
            ]);
        } else {
            //             "credit_card",
            // "gopay",
            // "shopeepay",
            // "permata_va",
            // "bca_va",
            // "bni_va",
            // "bri_va",
            // "echannel",
            // "other_va",
            // "Indomaret",
            // "alfamart",
            // "akulaku"
            $i = 1;
            # code...
            $tagihan = Tagihan::find($request->tagihan_id);

            $getUser = User::where("nisn", $request->input('user_id'))->first();
            $fee = $methode->percent == 1 ? ($request->input("total") * $methode->biayaTransaksi / 100) : $methode->biayaTransaksi;
            $total = $request->input("total") + $fee;
            $order_id = $getUser->nisn . '-' . $getUser->Transaksi->count();
            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $total,
                ],
                "item_details" => [
                    [
                        "id" => 1,
                        "price" => $request->input("total"),
                        "quantity" => 1,
                        "name" => DaftarTagihan::find($request->tagihan_id)->first()->nama
                    ],
                    [
                        "id" => 2,
                        "price" => $fee,
                        "quantity" => 1,
                        "name" => "Fee"
                    ],
                ],
                'customer_details' => [
                    'first_name' => $getUser->name,
                    'last_name' => $getUser->nisn,
                    'email' => $getUser->email,
                    'phone' => $getUser->nomerHP,
                ],
                "enabled_payments" => [MethodePembayaran::find($request->input('methode_pembayaran_id'))->nama],

            ];
            // dd($params);

            $snapToken = Snap::createTransaction($params);

            $data = [
                "user_id" => $getUser->id,
                "tanggal" => now(),
                "methode_pembayaran_id" => $methode->id,
                "tagihan_id" => $request->tagihan_id,
                "fee" => $fee,
                "total" => $request->input("total"),
                "status" => 3,
                "order_id" => $order_id,
                "snapToken" => $snapToken->redirect_url,
            ];

            Transaksi::create($data);
            // dd();
            return redirect()->away($snapToken->redirect_url);

            // header("Location:" . );
            // dd($tagihan->DaftarTagihan->nominal);
        }

        return back()->with("success", "Transaksi Baru Berhasil Di Simpan");
    });
    Route::get('payment-methods', function () {
        $methods = MethodePembayaran::all();
        return response()->json($methods);
    });
});
Route::post('login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'statusCode' => 200,
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }

    return response()->json([
        'statusCode' => 401,
        'message' => 'Invalid credentials'
    ], 401);
})->name('login');


// Hendel Mindrans

Route::prefix("Midtrans")->group(function () {

    Route::post("notif", function (Request $request) {
        $data = $request->all();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Notification received',
            "data" => $data
        ]);
    })->name("MidtransNotif");
    Route::get("finish", function (Request $request) {
        $data = $request->all();
        $transaksi = Transaksi::where("order_id", $data["order_id"]);
        switch ($data["transaction_status"]) {
            case "settlement":
                $transaksi->update([
                    "status" => 1
                ]);
                $total = $transaksi->sum("total");
                $tagihan = $transaksi->first()->Tagihan->first()->nominal;
                if ((-$total) == 0) {
                    # code...
                    $transaksi->first()->Tagihan->update([
                        "status" => 1
                    ]);
                    return redirect()->route('Transaksi.index');
                }
                return redirect()->route('Transaksi.index');
                break;
            case "pending":
                $transaksi->update([
                    "status" => 3
                ]);
                return redirect()->route('Transaksi.index');
                break;
            case "deny":
                $transaksi->update([
                    "status" => 4
                ]);
                return redirect()->route('Transaksi.index');
                break;
            case "expire":
                $transaksi->update([
                    "status" => 4
                ]);
                return redirect()->route('Transaksi.index');
                break;
            case "cancel":
                $transaksi->update([
                    "status" => 4
                ]);
                return redirect()->route('Transaksi.index');
                break;
        }
    })->name("MidtransFinish");
    Route::post("unfinish", function (Request $request) {
        $data = $request->all();
        $transaksi = Transaksi::where("order_id", $data["order_id"]);
        switch ($data["transaction_status"]) {
            case "settlement":
                $transaksi->update([
                    "status" => 1
                ]);
                $transaksi->first()->Tagihan->update([
                    "status" => 1
                ]);
                break;
            case "pending":
                $transaksi->update([
                    "status" => 3
                ]);
                break;
            case "deny":
                $transaksi->update([
                    "status" => 4
                ]);
                break;
            case "expire":
                $transaksi->update([
                    "status" => 4
                ]);
                break;
            case "cancel":
                $transaksi->update([
                    "status" => 4
                ]);
                break;
        }
    })->name("MidtransUnfinish");
    Route::post("error", function (Request $request) {
        $data = $request->all();
        return response()->json([
            'statusCode' => 200,
            'message' => 'Transaction error',
            "data" => $data
        ]);
    })->name("MidtransError");
});


Route::get("tagihanSiswa/{user}", function (User $user) {
    $tagihan = $user->Tagihan->where("status", 0);
    $data = [];
    foreach ($tagihan as $key => $value) {
        $data[] = [
            "id" => $value->id,
            "nama" => $value->nama,
            // "nominal" => $value->DaftarTagihan->nominal -
            "nominal" => $value->Transaksi == [] ? $value->DaftarTagihan->nominal : $value->DaftarTagihan->nominal - $value->Transaksi->sum("total"),
        ];
    }
    return response()->json($data);
})->name("apiTagihanSiswa");
