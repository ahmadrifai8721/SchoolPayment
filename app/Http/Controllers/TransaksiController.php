<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\DaftarTagihan;
use App\Models\Kelas;
use App\Models\MethodePembayaran;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class TransaksiController extends Controller
{

    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return Kelas::all();

        return view("Transaksi.TransaksiSiswa", [
            "title" => "Daftar Transaksi Siswa",
            "Transaksi" => Transaksi::withTrashed()->get(),
            "AnggotaKelas" => AnggotaKelas::all()->groupBy("rombongan_belajar_id"),
            "DaftarTagihan" => DaftarTagihan::withTrashed()->get(),
            "Kelas" => new Kelas,
            "MethodePembayaran" => MethodePembayaran::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        // return Kelas::all();

        return view("Transaksi.Transaksi", [
            "title" => "Bayar Tagihan",
            "Transaksi" => Transaksi::withTrashed()->get(),
            "AnggotaKelas" => AnggotaKelas::all()->groupBy("rombongan_belajar_id"),
            "DaftarTagihan" => DaftarTagihan::withTrashed()->get(),
            "Kelas" => new Kelas,
            "MethodePembayaran" => MethodePembayaran::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $methode = MethodePembayaran::find($request->input('methode_pembayaran_id'));

        if ($methode->type == "offline") {
            # code...
            // dd($methode);
            foreach ($request->input('daftar_tagihan_id') as $key => $value) {
                $fee = $methode->percent == 1 ? ($request->input("total") * $methode->biayaTransaksi / 100) : $request->input("total") + $methode->biayaTransaksi;
                $total = $request->input("total") + $fee;
                # code...
                $tagihan = Tagihan::find($value);
                $data = [
                    "user_id" => $request->input('user_id'),
                    "tanggal" => now(),
                    "methode_pembayaran_id" => $methode->id,
                    "tagihan_id" => $value,
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
            }
            return back()->with("success", "Transaksi Baru Berhasil Di Simpan");
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
            foreach ($request->input('daftar_tagihan_id') as $key => $value) {
                # code...
                $tagihan = Tagihan::find($value);

                $getUser = User::find($request->input('user_id'));
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
                            "id" => $i++,
                            "price" => $request->input("total"),
                            "quantity" => 1,
                            "name" => DaftarTagihan::find($value)->first()->nama
                        ],
                        [
                            "id" => $i++,
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
                    "user_id" => $request->input('user_id'),
                    "tanggal" => now(),
                    "methode_pembayaran_id" => $methode->id,
                    "tagihan_id" => $value,
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
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $TransaksiSiswa)
    {
        //
        dump($TransaksiSiswa->DetailTransaksi()->sum("nominal"));

        return $TransaksiSiswa;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $TransaksiSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $TransaksiSiswa)
    {
        //
        // $data = $request->input();

        // $data['satukali'] = false;
        // $data['berulang'] = false;
        // $data[$data["jenis"]] = true;

        // $TransaksiSiswa->update($data);

        // return back()->with("success", "Transaksi $TransaksiSiswa->nama Berhasil di Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $TransaksiSiswa)
    {
        //
        $TransaksiSiswa->deleteOrFail();

        return back()->with("success", "Transaksi $TransaksiSiswa->nama Berhasil Di Non Aktifkan");
    }

    public function restore($TransaksiSiswa)
    {
        $getdaftarTagDaftarTagihan = Transaksi::withTrashed()
            ->where('id', $TransaksiSiswa);
        $restore = $getdaftarTagDaftarTagihan->restore();

        return back()->with("success", "Transaksi " . $getdaftarTagDaftarTagihan->first()->nama . " Berhasil Di Aktifkan Kembali");
    }
}
