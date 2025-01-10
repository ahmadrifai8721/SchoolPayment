<?php

namespace App\Http\Controllers;


use App\Models\MethodePembayaran;
use Illuminate\Http\Request;

class MethodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("MetodePembayaran", [
            "title" => "Daftar Transaksi Siswa",
            "MethodePembayaran" => MethodePembayaran::withTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        MethodePembayaran::create($request->all());
        return back()->with("success", "Methode Pembayaran Baru Berhasil Di Simpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(MethodePembayaran $MethodePembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MethodePembayaran $MethodePembayaran)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MethodePembayaran $MethodePembayaran)
    {
        //
        //
        $data = $request->input();
        unset($data["_token"]);
        unset($data["_method"]);
        // dd($data);
        $MethodePembayaran->update($data);

        return back()->with("success", "Methode Pembayaran $MethodePembayaran->nama Berhasil di Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MethodePembayaran $MethodePembayaran)
    {
        //
        $MethodePembayaran->deleteOrFail();
        return back()->with("success", "Methode Pembayaran $MethodePembayaran->nama Berhasil Di Non Aktifkan");
    }

    public function restore($MethodePembayaran)
    {
        $getMethodePembayaran = MethodePembayaran::withTrashed()
            ->where('id', $MethodePembayaran);
        $restore = $getMethodePembayaran->restore();

        return back()->with("success", "Methode Pembayaran " . $getMethodePembayaran->first()->nama . " Berhasil Di Aktifkan Kembali");
    }
}
