<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\DaftarTagihan;
use App\Models\Kelas;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
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
        $data = $request->input();
        if ($request->input("kelas")) {
            $dataSiswa = json_decode(base64_decode($data['rombongan_belajar_id']));
            foreach ($dataSiswa as $key => $value) {
                # code...
                foreach ($data['daftar_Transaksi_id'] as $daftar_Transaksi_id) {
                    # code...
                    Transaksi::create([
                        'nama' => DaftarTagihan::find($daftar_Transaksi_id)->nama,
                        'user_id' => $value->user_id,
                        'daftar_Transaksi_id' => $daftar_Transaksi_id
                    ]);
                }
            }
            # code...
        } else {

            foreach ($data["user_id"] as $siswa) {
                foreach ($data['daftar_Transaksi_id'] as $daftar_Transaksi_id) {
                    # code...
                    Transaksi::create([
                        'nama' => DaftarTagihan::find($daftar_Transaksi_id)->nama,
                        'user_id' => $siswa,
                        'daftar_Transaksi_id' => $daftar_Transaksi_id
                    ]);
                }
            }
        }

        // Transaksi::create($data);


        return back()->with("success", "Transaksi Baru Berhasil Di Simpan");
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
