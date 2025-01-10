<?php

use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command("admin:new {name} {email} {password}", function ($name, $email, $password) {

    $add = User::create([
        "name" => $name,
        "email" => $email,
        "password" => bcrypt($password),
        "isAdmin" => 1,
    ]);
    $this->comment($add);
})->purpose("Add New Admin Account");
Artisan::command("admin:deactive {email}", function ($email) {

    $dell = User::where("email", $email)->delete();
    if ($dell) {
        # code...
        $this->comment("Data Admin $email Berhasil di Non Aktifkan");
    } else {
        $this->comment("Data Admin $email Tidak Di Temukan");
    }
})->purpose("Add deactive Admin Account");
Artisan::command("admin:active {email}", function ($email) {

    $dell = User::withTrashed()->where("email", $email)->restore();
    if ($dell) {
        # code...
        $this->comment("Data Admin $email Berhasil di Aktifkan");
    } else {
        $this->comment("Data Admin $email Tidak Di Temukan");
    }
})->purpose("Add active Admin Account");
Artisan::command("dapodik:import", function () {


    $userID = null;
    $i = 0;

    $this->comment("Import Rombel");

    $urlRombel = "http://" . env("DAPODIK_SERVER_IP") . ":" . env("DAPODIK_SERVER_PORT") .
        "/WebService/getRombonganBelajar?npsn=" .
        env("DAPODIK_SERVER_NPSN");
    $getBodyRombel = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('DAPODIK_SERVER_Token'),
    ])->get($urlRombel)->body();

    $getBodyRombel = json_decode($getBodyRombel);
    $progressBarGetRombel = $this->output->createProgressBar($getBodyRombel->results);
    $progressBarGetRombel->setMaxSteps($getBodyRombel->results);;
    $getBodyRombel = $getBodyRombel->rows;
    $progressBarGetRombel->start();

    foreach ($getBodyRombel as $key => $value) {
        if ($value->jenis_rombel == "1") {
            $kelas = Kelas::updateOrCreate(["rombongan_belajar_id" => $value->rombongan_belajar_id], [
                "rombongan_belajar_id" => $value->rombongan_belajar_id,
                "kelas" => $value->nama,
            ]);
            $progressBarGetRombel->advance();
        }
    }

    $progressBarGetRombel->finish();

    $this->comment("Import Daftar Siswa");

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
    $progressBar = $this->output->createProgressBar($getBody->results);
    $getBody = $getBody->rows;
    $progressBar->start();

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
        $progressBar->advance();
    }
    $progressBar->finish();

    $this->comment("Selesai Import Data Dari dapodik ");
})->purpose("Import Data From Dapodik");
