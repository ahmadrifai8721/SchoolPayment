<?php

namespace App\Http\Controllers;

use App\Models\AnggotaKelas;
use App\Models\DaftarTagihan;
use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return Kelas::all();

        return view("Tagihan.TagihanSiswa", [
            "title" => "Daftar Tagihan Siswa",
            "Tagihan" => Tagihan::withTrashed()->get(),
            "AnggotaKelas" => AnggotaKelas::all()->groupBy("rombongan_belajar_id"),
            "daftarTagihan" => DaftarTagihan::withTrashed()->get(),
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
                foreach ($data['daftar_tagihan_id'] as $daftar_tagihan_id) {
                    # code...
                    Tagihan::create([
                        'nama' => DaftarTagihan::find($daftar_tagihan_id)->nama,
                        'user_id' => $value->user_id,
                        'daftar_tagihan_id' => $daftar_tagihan_id
                    ]);
                }
            }
            # code...
        } else {

            foreach ($data["user_id"] as $siswa) {
                foreach ($data['daftar_tagihan_id'] as $daftar_tagihan_id) {
                    # code...
                    Tagihan::create([
                        'nama' => DaftarTagihan::find($daftar_tagihan_id)->nama,
                        'user_id' => $siswa,
                        'daftar_tagihan_id' => $daftar_tagihan_id
                    ]);
                }
            }
        }

        // Tagihan::create($data);


        return back()->with("success", "Tagihan Baru Berhasil Di Simpan");
    }

    /**
     * Display the specified resource.
     */
    public function show(Tagihan $tagihanSiswa)
    {
        //
        dump($tagihanSiswa->DetailTagihan()->sum("nominal"));

        return $tagihanSiswa;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $tagihanSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tagihan $tagihanSiswa)
    {
        //
        // $data = $request->input();

        // $data['satukali'] = false;
        // $data['berulang'] = false;
        // $data[$data["jenis"]] = true;

        // $tagihanSiswa->update($data);

        // return back()->with("success", "Tagihan $tagihanSiswa->nama Berhasil di Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $tagihanSiswa)
    {
        //
        $tagihanSiswa->deleteOrFail();

        return back()->with("success", "Tagihan $tagihanSiswa->nama Berhasil Di Non Aktifkan");
    }

    public function restore($tagihanSiswa)
    {
        $getdaftarTagihan = Tagihan::withTrashed()
            ->where('id', $tagihanSiswa);
        $restore = $getdaftarTagihan->restore();

        return back()->with("success", "Tagihan " . $getdaftarTagihan->first()->nama . " Berhasil Di Aktifkan Kembali");
    }
}
