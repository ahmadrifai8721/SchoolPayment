<?php

namespace App\Http\Controllers;

use App\Models\DaftarTagihan;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use Illuminate\Http\Request;

class DaftarTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("Tagihan.DaftarTagihan", [
            "title" => "Daftar Tagihan",
            "Tagihan" => DaftarTagihan::withTrashed()->get(),
            "AnggotaKelas" => AnggotaKelas::all()->groupBy("rombongan_belajar_id"),
            "Kelas" => new Kelas()
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
        $request->validate([
            'nominal' => "required|numeric",
            "nama" => 'required'
        ], [
            'nominal.required' => "Nominal belum di isi",
            'nominal.numeric' => "Nominal Harus Angka",
            'nama.required' => "Nama belum di isi",
        ]);
        $data = $request->input();

        DaftarTagihan::create($data);

        return back()->with("success", "Tagihan Baru Berhasil Di Simpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(DaftarTagihan $daftarTagihan)
    {
        //
        // return $daftarTagihan;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DaftarTagihan $daftarTagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DaftarTagihan $daftarTagihan)
    {
        //
        $data = $request->input();

        $data['satukali'] = false;
        $data['berulang'] = false;

        $daftarTagihan->update($data);

        return back()->with("success", "Tagihan $daftarTagihan->nama Berhasil di Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DaftarTagihan $daftarTagihan)
    {
        //
        $daftarTagihan->deleteOrFail();
        return back()->with("success", "Tagihan $daftarTagihan->nama Berhasil Di Non Aktifkan");
    }

    public function restore($daftarTagihan)
    {
        $getdaftarTagihan = DaftarTagihan::withTrashed()
            ->where('id', $daftarTagihan);
        $restore = $getdaftarTagihan->restore();

        return back()->with("success", "Tagihan " . $getdaftarTagihan->first()->nama . " Berhasil Di Aktifkan Kembali");
    }
}
